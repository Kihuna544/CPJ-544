<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SpecialTripClient;
use App\Models\TemporaryClient;
use Illuminate\Http\Request;

class SpecialTripClientController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $specialTripClient = SpecialTripClient::with('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions')
                            ->latest()
                            ->paginate($perPage);

        return response()->json($specialTripClient);
    }    


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'special_trip_id' => 'required|exists:special_trips,id',
            'client_id' => 'required|exists:temporary_clients',
            'amount_to_pay_for_the_special_trip' => 'required|numeric|min:0',   
        ]);

        $specialTripClient = SpecialTripClient::find($validated ['client_id']);
        $validated['client_name'] = $specialTripClient->client_name;
        $validated['created_by'] = auth()->id();


        $specialTripClient = SpecialTripClient::create($validated);

        return response()->json($specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions'), 201);
    }


    public function update(Request $request, SpecialTripClient $specialTripClient)
    {
        $validated = $request->validate
        ([
            'special_trip_id' => 'required|exists:special_trips,id',
            'client_id' => 'required|exists:temporary_clients,id',
            'amount_to_pay_for_the_special_trip' => 'required|numeric|min:0',   
        ]);

        $specialTripClient = TemporaryClient::find($validated ['client_id']);
        $validated['client_name'] = $specialTripClient->client_name;
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