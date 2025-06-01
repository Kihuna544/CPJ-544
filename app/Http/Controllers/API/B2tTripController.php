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
         
        ]);

        $validated['created_by'] = auth()->id();
        $b2tTrip = B2tTrip::create($validated);
        $b2tTrip->refreshTotals();

        return response()->json($b2tTrip->load('b2tTripClients', 'driver'), 201);
    }


    public function update(Request $request, B2tTrip $b2tTrip) 
    {
        $validated = $request->validate([
            'driver_id' => 'sometimes|required|exists:drivers,id',
            'trip_date' => 'sometimes|required|date',
        ]);
     
        $validated['updated_by'] = auth()->id();
        $b2tTrip->update($validated);
        $b2tTrip->refreshTotals();

        return response()->json
        ([
            'message' => 'Trip updatesd successfully',
            'b2tTrip' => $b2tTrip->load('b2tTripClients', 'driver'
        )], 200);
    }


    public function show(B2tTrip $b2tTrip)
    {
        return response()->json($b2tTrip->load('b2tTripClients', 'driver'));
    }


    public function destroy(B2tTrip $b2tTrip)
    {
        $b2tTrip->load('b2tTripClients', 'driver');

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
                    ->with('b2tTripClients', 'driver')
                    ->get();

        return response()->json($trashedTrip);
    }


    public function restore($id)
    {
        $trashedTrip = B2tTrip::onlyTrashed()->findOrFail($id);
        $trashedTrip->restore();

        return response()->json
        ([
            'message' => 'Trip was restored successfully',
            'trashed_trip' => $trashedTrip->load('b2tTripClient', 'driver')
        ], 200);
    }

 }