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

        $t2bTrip = T2bTrip::with(['driver', 't2bTripClients', 't2bClientItems', 't2bExpenses'])
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

        $t2bTrip = T2bTrip::create($validated);
        return response()->json($t2bTrip, 201);
    }

    public function update(Request $request, $id)
    {
        $t2bTrip = T2bTrip::findOrFail($id);

        $validated = $request->validate
        ([
            'driver_id' => 'required|exists:driver,id',
            'trip_date' => 'required|date',
        ]);

        $t2bTrip->update($validated);
        return response()->json($t2bTrip, 200);
    }

    public function show($id)
    {
        return T2bTrip::findOrFail($id);
    }

    public function destroy($id) 
    {
        T2bTrip::findOrFail($id)->delete();
        return response()->json(['message' => 'Trip deleted']);
    }
}