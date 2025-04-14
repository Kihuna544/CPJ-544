<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Client;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with('driver', 'clients')->latest()->get();
        return view('trips.index', compact('trips'));
    }

    public function create()
    {
        $drivers = Driver::all();
        $clients = Client::all();
        return view('trips.create', compact('drivers', 'clients'));
    }

    public function store(Request $request)
{
    $request->validate([
        'driver_id' => 'required|exists:drivers,id',
        'trip_date' => 'required|date',
        'destination' => 'required|string|max:255',
        'clients' => 'required|array|min:1',
        'clients.*.client_id' => 'required|exists:clients,id',
        'clients.*.delivery_amount' => 'required|numeric|min:0',
    ]);

    // Create trip
    $trip = Trip::create([
        'driver_id' => $request->driver_id,
        'trip_date' => $request->trip_date,
        'destination' => $request->destination,
    ]);

    // Attach clients with delivery amounts
    foreach ($request->clients as $clientData) {
        $trip->clients()->attach($clientData['client_id'], [
            'delivery_amount' => $clientData['delivery_amount'],
        ]);
    }

    return redirect()->route('trips.index')->with('success', 'Trip successfully created!');
}


    public function getPaymentStatus($clientId, Request $request)
    {
        $client = Client::findOrFail($clientId);

        // Get last trip where this client was involved
        $lastTrip = $client->trips()->latest()->first();

        $unpaid = 0;
        $lastPaymentDate = null;
        $lastPaymentAmount = 0;

        if ($lastTrip) {
            $pivot = $lastTrip->pivot ?? $lastTrip->clients()->where('client_id', $clientId)->first()->pivot;

            $unpaid = $pivot->total_to_pay - ($pivot->amount_paid ?? 0);
            $lastPaymentAmount = $pivot->amount_paid ?? 0;
            $lastPaymentDate = $pivot->updated_at ? Carbon::parse($pivot->updated_at)->format('Y-m-d') : null;
        }

        return response()->json([
            'unpaid_amount' => $unpaid,
            'last_payment_date' => $lastPaymentDate ?? 'N/A',
            'last_payment_amount' => $lastPaymentAmount,
        ]);
    }
}
