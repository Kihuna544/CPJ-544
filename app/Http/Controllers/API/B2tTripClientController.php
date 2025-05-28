<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\B2tTripClient;
use Illuminate\Http\Request;

class B2tTripClientController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $b2tTripClient = B2tTripClient::with('client', 'b2tTrip', 'payments', 'paymentTransactions')
                ->latest()
                ->paginated($perPage);

        return response()->json($b2tTripClient);
    }

    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'b2t_trip_id' => 'required|exists:b2t_trips, id',
            'client_id' => 'required|exists:clients, id',
            'client_name' => 'required|string|max:255',
            'no_of_sacks_per_client' => 'required|integer|min:0',
            'no_of_packages_per_client' => 'nullable|integer|min:0',
            'amount_to_pay_for_b2t' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = auth()->id();
        $b2tTripClient = B2tTripClient::where('client', 'b2tTrip', 'payments', 'paymentTransactions');

        return response()->json($b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions'), 201);
    }


    public function update(Request $request, B2tTripClient $b2tTripClient)
    {
        $validated = $request->validate
        ([
            'b2t_trip_id' => 'required|exists:b2t_trips, id',
            'client_id' => 'required|exists:clients, id',
            'client_name' => 'required|string|max:255',
            'no_of_sacks_per_client' => 'required|integer|min:0',
            'no_of_packages_per_client' => 'nullable|integer|min:0',
            'amount_to_pay_for_b2t' => 'required|numeric|min:0',  
        ]);

        $validated['updated_by'] = auth()->id();
        $b2tTripClient->upgrade($validated);

        return response()->json($b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions'), 200);
    }


    public function show(B2tTripClient $b2tTripClient)
    {
        return $b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions');
    }


    public function destroy(B2tTripClient $b2tTripClient)
    {
        $b2tTripClient->delete();

        return response()->json
            ([
                'message' => 'Client deleted successfully',
                'client' => $b2tTripClient->load('client', 'b2tTrip', 'payments', 'paymentTransactions'),
            ]);
    }
}

