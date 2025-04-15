<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Trip;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    // List all journeys (optional use)
    public function index()
    {
        $journeys = Journey::with('trip.driver')->latest()->get();
        return view('journeys.index', compact('journeys'));
    }

    // Show a specific journey
    public function show(Journey $journey)
    {
        $journey->load('trip.driver');
        return view('journeys.show', compact('journey'));
    }

    // Edit journey (e.g. mark status)
    public function edit(Journey $journey)
    {
        return view('journeys.edit', compact('journey'));
    }

    // Update journey status or type
    public function update(Request $request, Journey $journey)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $journey->update([
            'status' => $request->status,
        ]);

        return redirect()->route('trips.show', $journey->trip_id)->with('success', 'Journey updated.');
    }

    // We don't need create/store/destroy for journeys – they are auto-created with a trip
    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function destroy(Journey $journey) { abort(404); }
}
