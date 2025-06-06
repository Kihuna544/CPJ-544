<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\T2bTripClient;
use App\Models\TemporaryClient;
use Illuminate\Http\Request;

class T2bTripClientController extends Controller
{
    
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $t2bTripClients = T2bTripClient::with('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments')
                ->latest()
                ->paginate($perPage);

        return response()->json
        ([
            'message' => 'Success',
            't2bTripClient' => $t2bTripClients
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            't2b_trip_id' => 'required|exists:t2b_trips,id',
            'client_id' => 'required|exists:temporary_clients,id',
            'amount_to_pay_for_t2b' => 'required|numeric|min:0',
        ]);

        if(isset($validated['client_id']))
        {
             $t2bClient = TemporaryClient::findOrFail($validated ['client_id']);
             $validated['client_name'] = $t2bClient->client_name;
        }

        $validated['created_by'] = auth()->id();

        $t2bTripClient = T2bTripClient::create($validated);

        return response()->json
        ([
            'message' => 'Client added successfully',
            't2bTripClient' => $t2bTripClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments')
        ], 201);
    }


    public function update(Request $request, T2bTripClient $t2bTripClient)
    {
        $validated = $request->validate
        ([
            't2b_trip_id' => 'sometimes|required|exists:t2b_trips,id',
            'client_id' => 'sometimes|required|exists:temporary_clients,id',
            'amount_to_pay_for_t2b' => 'sometimes|required|numeric|min:0',
        ]);


        if(isset($validated['client_id']))
        {
            $t2bClient = TemporaryClient::findOrFail($validated ['client_id']);
            $validated['client_name'] = $t2bClient->client_name;
        }


        $validated['updated_by'] = auth()->id();


        $t2bTripClient->update($validated);

        return response()->json
        ([
            'message' => 'Client updated successfully',
            't2bTripClient' => $t2bTripClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments')
        ], 200);
    }


    public function show(T2bTripClient $t2bTripClient)
    {
        return response()->json
        ([
            'message' => 'Success',
            't2bTripClient' => $t2bTripClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments')
        ]);
    }


    public function destroy(T2bTripClient $t2bTripClient)
    {
        $t2bTripClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments');

        $t2bTripClient->deleted_by = auth()->id();
        $t2bTripClient->save();

        $trashedClient = $t2bTripClient;

        $t2bTripClient->delete();

        return response()->json
        ([
            'message' => 'Client deleted successfully',
            'trashedClient' => $trashedClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments'),
        ]);
    }


    public function trashed()
    {
        $trashedClients = T2bTripClient::onlyTrashed()  
                       ->with('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments')
                       ->paginate($request->query('per_page', 10))
                       ->get();
        
        return response()->json
        ([
            'message' => 'success',
            'trashedClients' => $trashedClients
        ]);
    }


    public function restore($id)
    {
        $trashedClient = T2bTripClient::onlyTrashed()->findOrFail($id);
        $trashedClient->restore();

        return response()->json
        ([
            'message' => 'Client restored successfully',
            'trashedClient' => $trashedClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments')
        ],200);
    }

}