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

        $b2tTrip = B2tTrip::with('trip', 'b2tTripClients')
                ->latest()
                ->paginate($perPage);

        return response()->json
        ([
            'message' => 'sucess',
            'b2tTrip' => $b2tTrip
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'normal_trip_id' => 'required|exists:normal_itenka_trips,id',
         
        ]);

        $validated['created_by'] = auth()->id();
        $b2tTrip = B2tTrip::create($validated);
        // on creating the trip, i expect no number of sacks is recorded
        return response()->json
        ([
            'message' => 'Trip created successfully',
            'b2tTrip' => $b2tTrip->load('trip', 'b2tTripClients')
        ], 201);
    }


    public function update(Request $request, B2tTrip $b2tTrip) 
    {
        $validated = $request->validate([
            'normal_trip_id' => 'sometimes|required|exists:normal_itenka_trips,id',
        ]);
     
        $validated['updated_by'] = auth()->id();
        $b2tTrip->update($validated);
        $b2tTrip->refreshTotals();

        return response()->json
        ([
            'message' => 'Trip updatesd successfully',
            'b2tTrip' => $b2tTrip->load('trip', 'b2tTripClients'
        )], 200);
    }


    public function show(B2tTrip $b2tTrip)
    {
        return response()->json
        ([
            'message' => 'success',
            'b2tTrip' => $b2tTrip->load('trip', 'b2tTripClients')
        ]);
    }


    public function destroy(B2tTrip $b2tTrip)
    {
        $b2tTrip->load('trip', 'b2tTripClients');

        $b2tTrip->deleted_by = auth()->id();
        $b2tTrip->save();


        $deletedTrip = $b2tTrip;

        $b2tTrip->delete();

        return response()->json
        ([

            'message' => 'Trip deleted successfully',
            'deleted_trip' => $deletedTrip
        ]);
    }

    
    public function trashed()
    {
        $trashedTrip = B2tTrip::onlyTrashed()
                    ->with('trip', 'b2tTripClients')
                    ->get();

        return response()->json
        ([
            'message' => 'success',
            'trashedTrip' => $trashedTrip
        ]);
    }


    public function restore($id)
    {
        $trashedTrip = B2tTrip::onlyTrashed()->findOrFail($id);
        $trashedTrip->restore();

        return response()->json
        ([
            'message' => 'Trip was restored successfully',
            'trashed_trip' => $trashedTrip->load('trip', 'b2tTripClient')
        ], 200);
    }

 }