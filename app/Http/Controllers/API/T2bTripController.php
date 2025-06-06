<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\T2bTrip;
use Illuminate\Http\Request;

class T2bTripController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $t2bTrips = T2bTrip::with(['trip', 't2bTripClients', 't2bClientItems'])
                    ->latest()
                    ->paginate($perPage);

        return response()->json
        ([
            'message' => 'Success',
            't2bTrips' => $t2bTrips
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'normal_trip_id' => 'sometimes|required|exists:normal_itenka_trips,id',
        ]);

        $validated['created_by'] = auth()->id();
        $t2bTrip = T2bTrip::create($validated);

        return response()->json
        ([
            'message' => 'Trip created successfully',
            't2bTrip' => $t2bTrip->load('trip', 't2bTripClients', 't2bClientItems')
        ], 201);
    }


    public function update(Request $request, T2bTrip $t2bTrip)
    {
        $validated = $request->validate
        ([
            'normal_trip_id' => 'required|exists:normal_itenka_trips,id',
        ]);

        $validated['updated_by'] = auth()->id();
        $t2bTrip->update($validated);

        return response()->json
        ([
            'message' => 'Trip updated successfully',
            't2bTrip' => $t2bTrip->load('trip', 't2bTripClients', 't2bClientItems')
        ], 200);
    }


    public function show(T2bTrip $t2bTrip)
    {
        return response()->json
        ([
            'message' => 'Success',
            't2bTrip' => $t2bTrip->load('trip', 't2bTripClients', 't2bClientItems')
        ]);
    }


    public function destroy(T2bTrip $t2bTrip) 
    {
        $t2bTrip->load('trip', 't2bTripClients', 't2bClientItems');

        $t2bTrip->deleted_by = auth()->id();
        $t2bTrip->save();

        $deletedTrip = $t2bTrip;

        $t2bTrip->delete();
        
        return response()->json
            ([
                'message'=> 'Trip deleted successfully',
                't2bTrip' => $deletedTrip
            ]);
    }


    public function trashed()
    {
        $trashedTrip = T2bTrip::onlyTrashed()
                     ->with('trip', 't2bTripClients', 't2bClientItems')
                     ->get();
        
        return response()->json($trashedTrip);
    }


    public function restore($id)
    {
        $trashedTrip = T2bTrip::onlyTrashed()->findOrFail($id);
        $trashedTrip->restore();

        return response()->json
        ([
            'message' => 'Trip restored successfully',
            'trashedTrip' => $trashedTrip->load('trip', 't2bTripClients', 't2bClientItems')
        ], 200);
    }
}