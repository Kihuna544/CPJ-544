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
        $t2bTripClient = T2bTripClient::with('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments')
                ->latest()
                ->paginate($perPage);

        return response()->json($t2bTripClient);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            't2b_trip_id' => 'required|exists:t2b_trips,id',
            'client_id' => 'required|exists:temporary_clients,id',
            'amount_to_pay_for_t2b' => 'required|numeric|min:0',
        ]);

        $t2bClient = TemporaryClient::find($validated ['client_id']);
        $validated['client_name'] = $t2bClient->client_name;
        $validated['created_by'] = auth()->id();


        $t2bTripClient = T2bTripClient::create($validated);

        return response()->json($t2bTripClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments'), 201);
    }


    public function update(Request $request, T2bTripClient $t2bTripClient)
    {
        $validated = $request->validate
        ([
            't2b_trip_id' => 'required|exists:t2b_trips,id',
            'client_id' => 'required|exists:temporary_clients,id',
            'amount_to_pay_for_t2b' => 'required|numeric|min:0',
        ]);


        $t2bClient = TemporaryClient::find($validated ['client_id']);
        $validated['client_name'] = $t2bClient->client_name;
        $validated['updated_by'] = auth()->id();


        $t2bTripClient->update($validated);

        return response()->json($t2bTripClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments'), 200);
    }


    public function show(T2bTripClient $t2bTripClient)
    {
        return $t2bTripClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments');
    }


    public function destroy(T2bTripClient $t2bTripClient)
    {
        $t2bTripClient->delete();

        return response()->json
        ([
            'message' => 'Client deleted successfully',
            'client' => $t2bTripClient->load('temporaryClient', 't2bTrip', 'clientItems', 'paymentTransactions', 'payments'),
        ]);
    }

}