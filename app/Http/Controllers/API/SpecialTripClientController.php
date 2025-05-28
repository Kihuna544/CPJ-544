<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SpecialTripClient;
use Illuminate\Http\Request;

class SpecialTripClientController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $specialTripClient = SpecialTripClient::with('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions');

        return response()->json($specialTripClient);
    }    


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'special_trip_id' => 'required|exists:special_trips,id',
            'client_id' => 'required|exists:temporary_clients',
            'client_name' => 'required|string|max:255',
            'amount_to_pay_for_the_special_trip',   
        ]);

        $validated['created_by'] = auth()->id();
        $specialTripClient = SpecialTripClient::create($validated);

        return response()->json($specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions'), 201);
    }


    public function update(Request $request, SpecialTripClient $specialTripClient)
    {
        $validated = $request->validate
        ([
            'special_trip_id' => 'required|exists:special_trips,id',
            'client_id' => 'required|exists:temporary_clients',
            'client_name' => 'required|string|max:255',
            'amount_to_pay_for_the_special_trip',   
        ]);

        $validated['updated_by'] = auth()->id();
        $specialTripClient->update($validated);

        return response()->json($specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions'), 200);
    }


    public function show(SpeciaTripClient $specialTripClient)
    {
        return response()->json($specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions'));
    }


    public function destroy(SpecialTripClient $specialTripClient)
    {
        $specialTripClient->delete();

        return response()->json
        ([
            'message' => 'Client deleted successfully',
            'specialTripClient' => $specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions')
        ]);
    }

}