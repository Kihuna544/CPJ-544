<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SpecialTripClientItem;
use Illuminate\Http\Request;

class SpecialTripClientItemController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $specialTripClientItems = SpecialTripClientItem::with('specialTripClient', 'specialTrip')
                            ->latest()
                            ->paginate($perPage);

        return response()->json
        ([
            'message' => 'Success',
            'specialTripClientItems' => $specialTripClientItems
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
           'special_trip_id' => 'required|exists:special_trips,id',
           'special_trip_client_id' => 'required|exists:special_trip_clients,id',
           'item_name' => 'required|string|max:255',
           'quantity' => 'required|numeric|min:0' 
        ]);

        $validated['created_by'] = auth()->id();
        $specialTripClientItem = SpecialTripClientItem::create($validated);

        return response()->json
        ([
            'message' => 'Item added successfully',
            'specialTripClient' => $specialTripClientItem->load('specialTripClient', 'specialTrip')
        ], 201);
    }


    public function update(Request $request, SpecialTripClientItem $specialTripClientItem)
    {
        $validated = $request->validate
        ([
           'special_trip_id' => 'sometimes|required|exists:special_trips,id',
           'special_trip_client_id' => 'sometimes|required|exists:special_trip_clients,id',
           'item_name' => 'sometimes|required|string|max:255',
           'quantity' => 'sometimes|required|numeric|min:0' 
        ]);

        $validated['updated_by'] = auth()->id();
        $specialTripClientItem->update($validated);

        return response()->json
        ([
            'message' => 'Item updated successfully',
            'specialTripClientItem' => $specialTripClientItem->load('specialTripClient', 'specialTrip')
        ], 200);   
    }


    public function show(SpecialTripClientItem $specialTripClientItem)
    {
        return response()->json
        ([
            'message' => 'Success',
            'specialTripClientItem' => $specialTripClientItem->load('specialTripClient', 'specialTrip')
        ]);
    }


    public function destroy(SpecialTripClientItem $specialTripClientItem)
    {
        $specialTripClientItem->load('specialTripClient', 'specialTrip');

        $specialTripClientItem->deleted_by = auth()->id();
        $specialTripClientItem->save();

        $trashedItem = $specialTripClientItem;

        $specialTripClientItem->delete();

        return response()->json
        ([
            'message' => 'Item deleted successfully',
            'specialTripClientItem' => $trashedItem
        ]);
    }


    public function trashed()
    {
        $trashedItems = SpecialTripClientItem::onlyTrashed()
                    ->with('specialTripClient', 'specialTrip')
                    ->get();

        return response()->json
        ([
            'message' => 'Success',
            'trashedItems' => $trashedItems
        ]);
    }


    public function restore($id)
    {
        $trashedItem = SpecialTripClientItem::onlyTrashed()->findOrFail($id);
        $trashedItem->restore();

        return response()->json
        ([
            'message' => 'Item restored successfully',
            'trashedItem' => $trashedItem->load('specialTripClient', 'specialTrip')
        ],200);
    }
}
