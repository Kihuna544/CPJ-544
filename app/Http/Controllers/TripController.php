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
        $data = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
            'destination' => 'required|string',
            'clients_data' => 'required|string'
        ]);

        $trip = Trip::create([
            'driver_id' => $data['driver_id'],
            'trip_date' => $data['trip_date'],
            'destination' => $data['destination'],
        ]);

        $clients = json_decode($data['clients_data'], true);

        foreach ($clients as $client) {
            $trip->clients()->attach($client['client_id'], [
                'delivery_amount' => $client['delivery_amount'],
                'unpaid_amount' => $client['unpaid_amount'],
                'total_to_pay' => $client['total_to_pay'],
            ]);
        }

        return redirect()->route('trips.index')->with('success', 'Trip created successfully.');
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
