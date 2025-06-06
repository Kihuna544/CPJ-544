<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NormalItenkaTrip;
use Illuminate\Http\Request;

class NormalItenkaTripController extends Controller
{
    public function index(Request $request)
    {
        $normalItenkaTrip = NormalItenkaTrip::with('driver', 't2bTrips', 'b2tTrips', 'expenses')
            ->latest()
            ->paginate();

        return response()->json
        ([
            'message' => 'success',
            'normalItenkaTrip' => $normalItenkaTrip
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
            'trip_details' => 'required|string'
        ]);

        $validated['created_by'] = auth()->id();
        $normalItenkaTrip = NormalItenkaTrip::create($validated);

        return response()->json
        ([
            'message' => 'Trip initiated successfully',
            'normalItenkaTrip' => $normalItenkaTrip->load('driver', 't2bTrips', 'b2tTrips', 'expenses')
        ]);
    }


    public function update(Request $request, NormalItenkaTrip $normalItenkaTrip)
    {
        $validated = $request->validate
        ([
            'driver_id' => 'sometimes|required|exists:drivers,id',
            'trip_date' => 'sometimes|required|date',
            'trip_details' => 'sometimes|required|string'
        ]);

        $validated['updated_by'] = auth()->id();
        $normalItenkaTrip->update();

        return response()->json
        ([
            'message' => 'Trip updated successfully',
            'normalItenkaTrip' => $normalItenkaTrip->load('driver', 't2bTrips', 'b2tTrips', 'expenses')
        ]);
    }


    public function show(NormalItenkaTrip $normalItenkaTrip)
    {
        return response()->json(
        [
            'message' => 'success',
            'normalItenkaTrip' => $normalItenkaTrip->load('driver', 't2bTrips', 'b2tTrips', 'expenses')
        ]);
    }


    public function destroy(NormalItenkaTrip $normalItenkaTrip)
    {
        $normalItenkaTrip->load('driver', 't2bTrips', 'b2tTrips', 'expenses');
        
        $normalItenkaTrip->deleted_by = auth()->id();
        $normalItenkaTrip->save();

        $trashedTrip = $normalItenkaTrip;

        $normalItenkaTrip->delete();

        return response()->json
        ([
            'message' => 'Trip deleted successfully',
            'trashedTrip' => $trashedTrip
        ]);

    }

    
    public function trashed()
    {
        $trashedTrip = NormalItenkaTrip::onlyTrashed()
                    ->with('driver', 't2bTrips', 'b2tTrips', 'expenses')
                    ->paginate($request->query('per_page', 10))
                    ->get();

        return response()->json
        ([
            'message' => 'success',
            'trashedTrip' => $trashedTrip
        ]);
    }


    public function restore($id)
    {
        $trashedTrip = NormalItenkaTrip::onlyTrashed()->findOrFail($id);
        $trashedTrip->restore();

        return response()->json
        ([
            'message' => 'Trip restored successfully',
            'trashedTrip' => $trashedTrip->load('driver', 't2bTrips', 'b2tTrips', 'expenses')
        ]);
    }
}