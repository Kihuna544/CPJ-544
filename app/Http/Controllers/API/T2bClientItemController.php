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
        $t2bClientItems = T2bClientItem::with('t2bClient', 't2bTrip')
                    ->latest()
                    ->paginate($perPage);

        return response()->json
        ([
            'message' => 'Success',
            't2bClientItems' => $t2bClientItems
        ]);
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

        return response()->json
        ([
            'message' => 'Item added successfully',
            't2bClientItem' => $t2bClientItem->load('t2bClient', 't2bTrip')
        ], 201);
    }


    public function update(Request $request, T2bClientItem $t2bClientItem)
    {
        $validated = $request->validate
        ([ 
            't2b_client_id' => 'sometimes|required|exists:t2b_trip_clients,id',
            't2b_trip_id' => 'sometimes|required|exists:t2b_trips,id',
            'item_name' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|numeric|min:0',   
        ]);

        $validated['updated_by'] = auth()->id();
        $t2bClientItem->update($validated);

        return response()->json
        ([
            'message' => 'Item updated successfully',
            't2bClientItem' => $t2bClientItem->load('t2bClient', 't2bTrip')
        ], 200);
    }


    public function show(T2bClientItem $t2bClientItem)
    {
        return response()->json
        ([
            'message' => 'Success',
            't2bClientItem' => $t2bClientItem->load('t2bClient', 't2bTrip')
        ]);
    }


    public function destroy(T2bClientItem $t2bClientItem)
    {
        $t2bClientItem->load('t2bClient', 't2bTrip');

        $t2bClientItem->deleted_by = auth()->id();
        $t2bClientItem->save();

        $trashedItem = $t2bClientItem;

        $t2bClientItem->delete();

        return response()->json
        ([
            'message' => 'Deleted successfully',
            't2bClientItem' => $trashedItem->load('t2bClient', 't2bTrip'),
        ]);
    }


    public function trashed()
    {
        $trashedItems = T2bClientItem::onlyTrashed()
                      ->with('t2bClient', 't2bTrip')
                      ->get();

        return response()->json
        ([
            'message' => 'Success',
            'trashedItems' => $trashedItems
        ]);
    }


    public function restore($id)
    {
        $trashedItem = T2bClientItem::onlyTrashed()->findOrFail($id);
        $trashedItem->restore();

        return response()->json
        ([
            'message' => 'Item restored successfully',
            'trashedItem' => $trashedItem->load('t2bClient', 't2bTrip')
        ],200);
    }
}
