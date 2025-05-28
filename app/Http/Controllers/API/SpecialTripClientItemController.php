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
        $specialTripClientItem = SpecialTripClientItem::with('specialTripClientItem', 'specialTrip')
                            ->latest()
                            ->paginate($perPage);

        return response()->json($specialTripClientItem);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
           'special_trip_id' => 'required|exists:special_trips,id',
           'special_trip_client_id' => 'requored|exists:special_trip_clients,id',
           'item_name' => 'required|string|max:255',
           'quantity' => 'required|numeric|min:0' 
        ]);

        $validated['created_by'] = auth()->id();
        $specialTripClientItem = SpecialTripClientItem::create($validated);

        return response()->json($specialTripClientItem->load('specialTripClientItem', 'specialTrip'), 201);
    }


    public function update(Request $request, SpecialTripClientItem $specialTripClientItem)
    {
        $validated = $request->validate
        ([
           'special_trip_id' => 'required|exists:special_trips,id',
           'special_trip_client_id' => 'requored|exists:special_trip_clients,id',
           'item_name' => 'required|string|max:255',
           'quantity' => 'required|numeric|min:0' 
        ]);

        $validated['updated_by'] = auth()->id();
        $specialTripClientItem->create($validated);

        return response()->json($specialTripClientItem->load('specialTripClientItem', 'specialTrip'), 200);   
    }


    public function show(SpecialTripClientItem $specialTripClientItem)
    {
        return response()->json($specialTripClientItem->load('specialTripClientItem', 'specialTrip'));
    }


    public function destroy(SpecialTripClientItem $specialTripClientItem)
    {
        $specialTripClientItem->delete();

        return response()->json
        ([
            'message' => 'Item deleted successfully',
            'specialTripClientItem' => $specialTripClientItem->load('specialTripClientItem', 'specialTrip')
        ]);
    }
}
