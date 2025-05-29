<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\T2bClientItem;
use Illuminate\Http\Request;

class T2bClientItemController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $t2bClientItem = T2bClientItem::with('t2bClient', 't2bTrip')
                    ->latest()
                    ->paginate($perPage);

        return response()->json($t2bClientItem);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            't2b_client_id' => 'required|exists:t2b_trip_clients,id',
            't2b_trip_id' => 'required|exists:t2b_trips,id',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = auth()->id();
        $t2bClientItem = T2bClientItem::create($validated);

        return response()->json($t2bClientItem->load('t2bClient', 't2bTrip'), 201);
    }


    public function update(Request $request, T2bClientItem $t2bClientItem)
    {
        $validated = $request->validate
        ([ 
            't2b_client_id' => 'required|exists:t2b_trip_clients,id',
            't2b_trip_id' => 'required|exists:t2b_trips,id',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|numeric:min:0',   
        ]);

        $validated['updated_by'] = auth()->id();
        $t2bClientItem->update($validated);

        return response()->json($t2bClientItem->load('t2bClient', 't2bTrip'), 200);
    }


    public function show(T2bClientController $t2bClientItem)
    {
        return $t2bClientItem->load('t2bClient', 't2bTrip');
    }


    public function destroy(T2bClientItem $t2bClientItem)
    {
        $t2bClientItem->delete();

        return response()->json
        ([
            'message' => 'Deleted successfully',
            'client' => $t2bClientItem->load('t2bClient', 't2bTrip'),
        ]);
    }
}
