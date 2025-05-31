<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\B2tTrip; 
use Illuminate\Http\Request;

class B2tTripController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $b2tTrip = B2tTrip::with('b2tTripClients', 'driver')
                ->OrderByDesc('trip_date')
                ->paginate($perPage);

        return response()->json($b2tTrip);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
            'total_number_of_sacks' => 'nullabel|integer|min:0',
            'total_number_of_packages' => 'nullable|integer|min:0', 
        ]);

        $validated['created_by'] = auth()->id();
        $b2tTrip = B2tTrip::create($validated);

        return response()->json($b2tTrip->load('b2tTripClients', 'driver'), 201);
    }


    public function update(Request $request, B2tTrip $b2tTrip) 
    {
        $validated = $request->validate([
            'driver_id' => 'sometimes|required|exists:drivers,id',
            'trip_date' => 'sometimes|required|date',
            'total_number_of_sacks' => 'nullable|integer|min:0', 
            'total_number_of_packages' => 'nullable|integer|min:0', 
        ]);

        $validated['updated_by'] = auth()->id();
        $b2tTrip->update($validated);

        return response()->json($b2tTrip->load('b2tTripClients', 'driver'), 200);
    }


    public function show(B2tTrip $b2tTrip)
    {
        return response()->json($b2tTrip->load('b2tTripClients', 'driver'));
    }


    public function destroy(B2tTrip $b2tTrip)
    {
        $b2tTrip->delete();

        return response()->json
        ([
            'message' => 'Trip deleted successfully',
            'b2tTrip' => $b2tTrip->load('b2tTripClients', 'driver')
        ]);
    }


    public function refreshTotals(B2tTrip $b2tTrip)
    {
        $b2tTrip->update
        ([
            'total_number_of_sacks' => $b2tTrip->b2tTripClients()->sum('no_of_sacks_per_client'),
            'total_number_of_packages' => $b2tTrip->b2tTripClients()->sum('no_of_packages_per_client'),
        ]);


        return response()->json
        ([
            'message' => 'Total updated successfully',
            'trip' => $b2tTrip->load('b2tTripClients', 'driver'),
        ]);
    }
}