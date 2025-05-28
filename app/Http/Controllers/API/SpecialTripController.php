<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SpecialTrip;
use Illuminate\Http\Request;

class SpecialTripController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $specialTrip = SpecialTrip::with('driver', 'specialTripItems, specialTripClients')
                    ->latest()
                    ->paginate($perPage);

        return response()->json($specialTrip);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'driver_id' => 'required|exists:drivers,id',
            'client_id' => 'required|exists:temporary_clients,id',
            'trip_date' => 'required|date',
            'trip_destination' => 'required|string|max:255',
            'trip_status' => 'required|string',//NOTE
        ]);

        $validated['created_by'] = auth()->id();
        $specialTrip = SpecialTrip::create($validated);

        return response()->json($specialTrip->load('driver', 'specialTripItems, specialTripClients'), 201);
    }


    public function update(Request $request, SpecialTrip $specialTrip)
    {
        $validated = $request->validate
        ([
            'driver_id' => 'required|exists:drivers,id',
            'client_id' => 'required|exists:temporary_clients,id',
            'trip_date' => 'required|date',
            'trip_destination' => 'required|string|max:255',
            'trip_status' => 'required|string',//NOTE
        ]);

        $validate['updated_by'] = auth()->id();
        $specialTrip = SpecialTrip::update($validated);

        return response()->json($specialTrip->load('driver', 'specialTripItems, specialTripClients'), 200);
    }


    public function show(SpecialTrip $specialTrip)
    {
        return response()->json($specialTrip->load('driver', 'specialTripItems, specialTripClients'));
    }


    public function destroy(SpecialTrip $specialTrip)
    {
        $specialTrip->delete();

        return response()->json
        ([
            'message' => 'Trip deleted successfully',
            'specialTrip' => $specialTrip->load('driver', 'specialTripItems, specialTripClients'),
         ]);
    }
}
