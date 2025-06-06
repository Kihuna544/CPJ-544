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
        $specialTrips = SpecialTrip::with('driver', 'specialTripItems', 'specialTripClients')
                    ->latest()
                    ->paginate($perPage);

        return response()->json
        ([
            'message' => 'Success',
            'specialTrips' => $specialTrips
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
            'trip_destination' => 'required|string|max:255',
        ]);

        $validated['created_by'] = auth()->id();
        $specialTrip = SpecialTrip::create($validated);

        return response()->json
        ([
            'message' => 'Trip initiated successfully',
            'specialTrip' => $specialTrip->load('driver', 'specialTripItems', 'specialTripClients')
        ], 201);
    }


    public function update(Request $request, SpecialTrip $specialTrip)
    {
        $validated = $request->validate
        ([
            'driver_id' => 'sometimes|required|exists:drivers,id',
            'trip_date' => 'sometimes|required|date',
            'trip_destination' => 'sometimes|required|string|max:255',
        ]);

        $validated['updated_by'] = auth()->id();
        $specialTrip->update($validated);

        return response()->json
        ([
            'message' => 'Trip updated successfully',
            'specialTrip' => $specialTrip->load('driver', 'specialTripItems', 'specialTripClients')
        ], 200);
    }


    public function show(SpecialTrip $specialTrip)
    {
        return response()->json
        ([
            'message' => 'Success',
            'specialTrip' => $specialTrip->load('driver', 'specialTripItems', 'specialTripClients')
        ]);
    }


    public function destroy(SpecialTrip $specialTrip)
    {
        $specialTrip->load('driver', 'specialTripItems', 'specialTripClients');

        $specialTrip->deleted_by = auth()->id();
        $specialTrip->save();

        $trashedTrip = $specialTrip;

        $specialTrip->delete();

        return response()->json
        ([
            'message' => 'Trip deleted successfully',
            'specialTrip' => $trashedTrip
         ]);
    }


    public function trashed()
    {
        $trashedTrips = SpecialTrip::onlyTrashed()
                    ->with('driver', 'specialTripItems', 'specialTripClients')
                    ->get();

        return response()->json
        ([
            'message' => 'Success',
            'trashedTrips' => $trashedTrips
        ]);
    }


    public function restore($id)
    {
        $trashedTrip = SpecialTrip::onlyTrashed()->findOrFail($id);
        $trashedTrip->restore();

        return response()->json
        ([
            'message' => 'Trip restored successfully',
            'trashedTrip' => $trashedTrip->load('driver', 'specialTripItems', 'specialTripClients')
        ], 200);
    }
}
