<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Client;
use App\Models\Driver;
use Illuminate\Http\Request;

class TripController extends Controller
{
    // Show list of trips
    public function index()
    {
        $trips = Trip::with(['client', 'driver'])->latest()->get();
        return view('trips.index', compact('trips'));
    }

    // Show trip creation form
    public function create()
    {
        $clients = Client::all();
        $drivers = Driver::all();
        return view('trips.create', compact('clients', 'drivers'));
    }

    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
            'destination' => 'required|string|max:255',
            'client_ids' => 'required|array',
        ]);

        // Create a trip
        $trip = Trip::create([
            'driver_id' => $request->driver_id,
            'trip_date' => $request->trip_date,
            'destination' => $request->destination,
        ]);

        // Attach clients to this trip (assuming pivot with extra details later)
        $trip->clients()->attach($request->client_ids);

        return redirect()->route('trips.index')->with('success', 'Trip created successfully!');
    }
}

