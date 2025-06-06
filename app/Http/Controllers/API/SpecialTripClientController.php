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
        $specialTripClients = SpecialTripClient::with('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions')
                            ->latest()
                            ->paginate($perPage);

        return response()->json
        ([
            'message' => 'success',
            'specialTripClients' => $specialTripClients
        ]);
    }    


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'special_trip_id' => 'required|exists:special_trips,id',
            'client_id' => 'required|exists:temporary_clients,id',
            'amount_to_pay_for_the_special_trip' => 'required|numeric|min:0',   
        ]);

        $client = TemporaryClient::find($validated ['client_id']);
        $validated['client_name'] = $client->client_name;
        $validated['created_by'] = auth()->id();


        $specialTripClient = SpecialTripClient::create($validated);

        return response()->json
        ([
            'message' => 'Client created successfully',
            'specialTripClient' => $specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions')
        ], 201);
    }


    public function update(Request $request, SpecialTripClient $specialTripClient)
    {
        $validated = $request->validate
        ([
            'special_trip_id' => 'sometimes|required|exists:special_trips,id',
            'client_id' => 'sometimes|required|exists:temporary_clients,id',
            'amount_to_pay_for_the_special_trip' => 'sometimes|required|numeric|min:0',   
        ]);

        $client = TemporaryClient::find($validated ['client_id']);
        $validated['client_name'] = $client->client_name;
        $validated['updated_by'] = auth()->id();

        
        $specialTripClient->update($validated);

        return response()->json
        ([
            'message' => 'Client updated successfully',
            'specialTripClient' => $specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions')
        ], 200);
    }


    public function show(SpecialTripClient $specialTripClient)
    {
        return response()->json
        ([
            'message' => 'success',
            'specialTripClient' => $specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions')
        ]);
    }


    public function destroy(SpecialTripClient $specialTripClient)
    {
        $specialTripClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions');

        $specialTripClient->deleted_by = auth()->id();
        $specialTripClient->save();
        
        $trashedClient = $specialTripClient;

        $specialTripClient->delete();

        return response()->json
        ([
            'message' => 'Client deleted successfully',
            'specialTripClient' => $trashedClient
        ]);
    }
    

    public function trashed()
    {
        $trashedClients = SpecialTripClient::onlyTrashed()
                        ->with('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions')
                        ->paginate($request->query('per_page', 10))
                        ->get();

        return response()->json
        ([
            'message' => 'Success',
            'trashedClients' => $trashedClients
        ]);
    }


    public function restore($id)
    {
        $trashedClient = SpecialTripClient::onlyTrashed()->findOrFail($id);
        $trashedClient->restore();

        return response()->json
        ([
            'message' => 'Client restored successfully',
            'trashedClient' => $trashedClient->load('client', 'specialTrip', 'specialTripClientItems', 'payments', 'paymentTransactions')
        ], 200);
    }

}