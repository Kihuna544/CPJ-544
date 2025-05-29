<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $paymentTransaction = PaymentTransaction::with('payment', 't2bClient', 'b2tClient', 'specialTripClient')
                            ->OrderByDesc('payment_date')
                            ->paginate($perPage);

        return response()->json($paymentTransaction);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            'payment_id' => 'required|exists:payments,id',
            't2b_trip_client_payment_id' => 'nullable|exixst:t2b_trip_clients,id',
            'b2t_trip_client_payment_id' => 'nullable|exists:b2t_trip_clients,id',
            'special_trip_client_payment_id' => 'nullable|exists:special_trip_clients,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => '', // should be validated
            'notes' => ''   // should be validated
        ]);

        $validated['created_by'] = auth()->id();
        $paymentTransaction = PaymentTransaction::create($validated);

        return response()->json($paymentTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient'), 201);
    }


    public function update(Request $request, PaymentTransaction $paymentTransaction)
    {
        $validated = $request->validate
        ([
            'payment_id' => 'required|exists:payments,id',
            't2b_trip_client_payment_id' => 'nullable|exixst:t2b_trip_clients,id',
            'b2t_trip_client_payment_id' => 'nullable|exists:b2t_trip_clients,id',
            'special_trip_client_payment_id' => 'nullable|exists:special_trip_clients,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => '', // should be validated
            'notes' => ''   // should be validated
        ]);

        $validated['updated_by'] = auth()->id();
        $paymentTransaction->update($validated);

        return response()->json($paymentTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient'), 200);
    }


    public function show(PaymentTransaction $paymentTransaction)
    {
        return response()->json($paymentTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient'));
    }


    public function destroy(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction->delete;

        return response()->json
        ([
            'message' => 'Transaction deleted',
            'paymentTransaction' => $paymentTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient')
        ]);
    }
}