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
            'b2t_trip_id' => 'required|exists:b2t_trips,id',
            'client_id' => 'required|exists:clients,id',
            'no_of_sacks_per_client' => 'required|integer|min:0',
            'no_of_packages_per_client' => 'nullable|integer|min:0',
            'amount_to_pay_for_b2t' => 'required|numeric|min:0',
        ]);

        if(isset($validated['client_name']))
        {
            $b2tClient = Client::find($validated ['client_id']);
            $validated['client_name'] = $b2tClient->client_name;
        }

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

        if(isset($validated['client_id']))
        {
            $b2tClient = Client::find($validated['client_id']);
            $validated['client_name'] = $b2tClient->client_name ?? 'Unkonwn Client';
        }

        $validated['updated_by'] = auth()->id();


        $b2tTripClient->update($validated);

        return response()->json
        ([
            'message' => 'Client updated successfully',
            'b2tTripClient' => $b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions'
        )], 200);
    }


    public function show(B2tTripClient $b2tTripClient)
    {
        return response()->json($b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions'));
    }


    public function destroy(B2tTripClient $b2tTripClient)
    {
        $b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions');

        $b2tTripClient->deleted_by = auth()->id();
        $b2tTripClient->save();

        $deletedClient = $b2tTripClient;

        $b2tTripClient->delete();

        return response()->json
        ([
            'message' => 'Client deleted successfully',
            'deletedClient' => $deletedClient
        ]);
    }


    public function trashed()
    {
        $trashedClient = B2tTripClient::onlyTrashed()
                    ->with('client', 'b2tTrip', 'payments', 'paymentTransactions')
                    ->get();

        return response()->json($trashedClient);
    }


    public function restore($id)
    {
        $trashedClient = B2tTripClient::onlyTrashed()->findOrFail($id);
        $trashedClient->restore();

        return response()->json
        ([
            'message' => 'Client restored successfully',
            'trashedClient' => $trashedClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions')
        ], 200);
    }
}

