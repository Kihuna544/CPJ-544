<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $payment = Payment::with('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions', 'getTotalPaidAttribute')
                ->latest()
                ->paginate($perPage);

        return response()->json($payment);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            't2b_trip_client_id' => 'nullable|exists:t2b_trip_clients,id',
            'b2t_trip_client_id' => 'nullable|exists:b2t_trip_clients,id',
            'special_trip_client_id' => 'nullable|exists:special_trip_clients,id',
            'client_name' => 'required|string|max:255', // should not have an input field in the front-end 
            'amount_to_pay_for_the_special_trip' => 'nullable|numeric|min:0',
            'amount_to_pay_for_b2t' => 'nullable|numeric|min:0',
            'amount_to_pay_for_t2b' => 'nullable|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'amount_unpaid' => 'required|numeric|min:0',
            'status' => '', // should be validated
            'notes' => ''   // should be validated
        ]);

        $amountUnpaid = null;

        if($request->has('amount_to_pay_for_the_special_trip'))
        {
            $amountUnpaid = amount_to_pay_for_the_special_trip - amount_paid;
            $validated['amount_unpaid'] = $amountUnpaid;
        }

        elseif($request->has('amount_to_pay_for_b2t'))
        {
            $amountUnpaid = amount_to_pay_for_b2t - amount_paid;
            $validated['amount_unpaid'] = $amountUnpaid;
        }

        elseif($request->has('amount_to_pay_for_t2b'))
        {
            $amountUnpaid = amount_to_pay_for_t2b - amount_paid;
            $validated['amount_unpaid'] = $amountUnpaid;
        }

        if($amountUnpaid)
        {
            $validated['amount_unpaid'] = $amountUnpaid;
        }


        $validated['created_by'] = auth()->id();
        $payment = Payment::create($validated);

        return response()->json($payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions', 'getTotalPaidAttribute'), 201);
    }


    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate
        ([
            't2b_trip_client_id' => 'nullable|exists:t2b_trip_clients,id',
            'b2t_trip_client_id' => 'nullable|exists:b2t_trip_clients,id',
            'special_trip_client_id' => 'nullable|exists:special_trip_clients,id',
            'client_name' => 'required|string|max:255', // should not have an input field in the front-end 
            'amount_to_pay_for_the_special_trip' => 'nullable|numeric|min:0',
            'amount_to_pay_for_b2t' => 'nullable|numeric|min:0',
            'amount_to_pay_for_t2b' => 'nullable|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'amount_unpaid' => 'required|numeric|min:0',
            'status' => '', // should be validated
            'notes' => ''   // should be validated
        ]);

        $amountUnpaid = null;

        if($request->has('amount_to_pay_for_the_special_trip'))
        {
            $amountUnpaid = amount_to_pay_for_the_special_trip - amount_paid;
            $validated['amount_unpaid'] = $amountUnpaid;
        }

        elseif($request->has('amount_to_pay_for_b2t'))
        {
            $amountUnpaid = amount_to_pay_for_b2t - amount_paid;
            $validated['amount_unpaid'] = $amountUnpaid;
        }

        elseif($request->has('amount_to_pay_for_t2b'))
        {
            $amountUnpaid = amount_to_pay_for_t2b - amount_paid;
            $validated['amount_unpaid'] = $amountUnpaid;
        }

        if($amountUnpaid)
        {
            $validated['amount_paid'] = $amountUnpaid;
        }

        $validated['created_by'] = auth()->id();
        $payment->update($validated);

        return response()->json($payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions', 'getTotalPaidAttribute'), 200);
    }


    public function show(Payment $payment)
    {
        return response()->json($payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions', 'getTotalPaidAttribute'));
    }


    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json
        ([
            'message' => 'Payment deleted succesfully',
            'payment' => $payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions', 'getTotalPaidAttribute')
        ]);
    }
}