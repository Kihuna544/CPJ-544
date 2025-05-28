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

        $t2bTrip = T2bTrip::with(['driver', 't2bTripClients', 't2bClientItems'])
                    ->orderByDesc('trip_date')
                    ->paginate($perPage);

        return response()->json($t2bTrip);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
        ]);

        $validated['created_by'] = auth()->id();
        $t2bTrip = T2bTrip::create($validated);

        return response()->json($t2bTrip->load('driver', 't2bTripClients', 't2bClientItems'), 201);
    }


    public function update(Request $request, T2bTrip $t2bTrip)
    {
        $validated = $request->validate
        ([
            'driver_id' => 'required|exists:drivers,id',
            'trip_date' => 'required|date',
        ]);

        $validated['updated_by'] = auth()->id();
        $t2bTrip->update($validated);

        return response()->json($t2bTrip->load('driver', 't2bTripClients', 't2bClientItems'), 200);
    }


    public function show(T2bTrip $t2bTrip)
    {
        return response()->json($t2bTrip->load('driver', 't2bTripClients', 't2bClientItems'));
    }


    public function destroy(T2bTrip $t2bTrip) 
    {
        $t2bTrip->delete();
        
        return response()->json
            ([
                'message'=> 'Trip deleted successfully',
                't2bTrip' => $t2bTrip->load('driver', 't2bTripClients', 't2bClientItems'),
            ]);
    }
}