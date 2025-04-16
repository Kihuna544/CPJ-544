<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Driver;
use App\Models\Journey;
use App\Models\Client;
use Illuminate\Http\Request;

class TripController extends Controller
{
    // Show list of all trips
    public function index()
    {
        $trips = Trip::with(['driver', 'journeys'])->latest()->paginate(10);
        return view('trips.index', compact('trips'));
    }

    // Show form to create a new trip
    public function create()
    {
        $drivers = Driver::all();
        return view('trips.create', compact('drivers'));
    }

    // Store new trip in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
            'status' => 'required|in:pending,completed',
            'notes' => 'nullable|string|max:255',
                ]);

        $trip = Trip::create([
            'driver_id' => $validated['driver_id'],
            'trip_date' => $validated['trip_date'],
            'status' => 'pending',
            'notes' => $request->input('notes'),
        ]);

        // Optionally: create default town-to-bush and bush-to-town journeys here
        Journey::create([
            'trip_id' => $trip->id,
            'type' => 'T2B', // Town to Bush
            'status' => 'in_progress',
        ]);

        Journey::create([
            'trip_id' => $trip->id,
            'type' => 'B2T', // Bush to Town
            'status' => 'pending',
        ]);

        return redirect()->route('trips.show', $trip)->with('success', 'Trip created successfully.');
    }

    // Show a single trip and its details
    public function show(Trip $trip)
    {
        $trip->load(['driver', 'journeys', 'clientParticipations.client', 'expenses', 'payments']);
        return view('trips.show', compact('trip'));
    }

    // Show form to edit a trip
    public function edit(Trip $trip)
    {
        $drivers = Driver::all();
        return view('trips.edit', compact('trip', 'drivers'));
    }

    // Update the trip
    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
            'status' => 'required|in:pending,completed',
        ]);

        $trip->update($validated);

        return redirect()->route('trips.index')->with('success', 'Trip updated successfully.');
    }

    // Delete a trip
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Trip deleted successfully.');
    }
}
