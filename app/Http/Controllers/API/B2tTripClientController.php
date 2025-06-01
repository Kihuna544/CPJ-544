<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\B2tTripClient;
use App\Models\Client;
use Illuminate\Http\Request;

class B2tTripClientController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $b2tTripClient = B2tTripClient::with('client', 'b2tTrip', 'payments', 'paymentTransactions')
                ->latest()
                ->paginate($perPage);

        return response()->json($b2tTripClient);
    }

    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'b2t_trip_id' => 'required|exists:b2t_trips, id',
            'client_id' => 'required|exists:clients, id',
            'no_of_sacks_per_client' => 'required|integer|min:0',
            'no_of_packages_per_client' => 'nullable|integer|min:0',
            'amount_to_pay_for_b2t' => 'require d|numeric|min:0',
        ]);

        $b2tclient = Client::find($validated ['client_id']);
        $validated['client_name'] = $b2tclient->client_name;
        $validated['created_by'] = auth()->id();
        
        $b2tTripClient = B2tTripClient::create($validated);

        return response()->json($b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions'), 201);
    }


    public function update(Request $request, B2tTripClient $b2tTripClient)
    {
        $validated = $request->validate
        ([
            'b2t_trip_id' => 'sometimes|required|exists:b2t_trips, id', 
            'client_id' => 'sometimes|required|exists:clients, id',
            'no_of_sacks_per_client' => 'sometimes|required|integer|min:0',
            'no_of_packages_per_client' => 'nullable|integer|min:0',
            'amount_to_pay_for_b2t' => 'sometimes|required|numeric|min:0',  
        ]);

        $b2tclient = Client::find($validated ['client_id']);
        $validated['client_name'] = $b2tclient->client_name;
        $validated['updated_by'] = auth()->id();


        $b2tTripClient->update($validated);

        return response()->json($b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions'), 200);
    }


    public function show(B2tTripClient $b2tTripClient)
    {
        return $b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions');
    }


    public function destroy(B2tTripClient $b2tTripClient)
    {
        $b2tclient->load('client', 'b2tTrip', 'payments', 'paymentTransactions');

        $b2tclient->deleted_by = auth()->id();
        $b2tclient->save();

        $deletedClient = $b2tclient;

        $b2tTripClient->delete();

        return response()->json
            ([
                'message' => 'Client deleted successfully',
                'deletedTrip' => $deletedClient
            ]);
    }
}

