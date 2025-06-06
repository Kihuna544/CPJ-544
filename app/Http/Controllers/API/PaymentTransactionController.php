<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $paymentTransaction = PaymentTransaction::with('payment', 't2bClient', 'b2tClient', 'specialTripClient')
                            ->OrderByDesc('payment_date')
                            ->paginate($perPage);

        return response()->json
        ([
            'message' => 'success',
            'paymentTransaction' => $paymentTransaction
        ]);
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
            'notes' => 'nullable|string|max:10000'
        ]);

        $validated['created_by'] = auth()->id();

        $paymentTransaction = PaymentTransaction::create($validated);

        // computing the amount unpaid after getting the amount paid and saving it to the payment table
        $payment = Payment::find($validated['payment_id']);
        $totalPaid = PaymentTransaction::where('payment_id', $validated['payment_id'])->sum('amount_paid');
        $totalDue = ($payment->amount_to_pay_for_the_special_trip ?? 0) +
                    ($payment->amount_to_pay_for_b2t ?? 0) +
                    ($payment->amount_to_pay_for_t2b ?? 0);

        $amountUnpaid = max($totalDue - $totalPaid, 0);
        $payment->amount_unpaid = $amountUnpaid;

        if($amountUnpaid == 0)
        {
            $payment->status = 'paid';
        }
        elseif($amountUnpaid== $totalDue) 
        {
            $payment->status = 'un_paid';
        }
        else{
            $payment->status = 'partially_paid';
        }

        $payment->save();

        return response()->json
        ([
            'message' => 'Transaction created successfully',
            'paymentTransaction' => $paymentTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient')
        ], 201);
    }


    public function update(Request $request, PaymentTransaction $paymentTransaction)
    {
        $validated = $request->validate
        ([
            'payment_id' => 'sometimes|required|exists:payments,id',
            't2b_trip_client_payment_id' => 'nullable|exists:t2b_trip_clients,id',
            'b2t_trip_client_payment_id' => 'nullable|exists:b2t_trip_clients,id',
            'special_trip_client_payment_id' => 'nullable|exists:special_trip_clients,id',
            'amount_paid' => 'sometimes|required|numeric|min:0',
            'payment_date' => 'sometimes|required|date',
            'notes' => 'nullable|string|max:10000'  
        ]);

        
        $validated['updated_by'] = auth()->id();
        $paymentTransaction->update($validated);

        // computing the amount unpaid after getting the amount paid and saving it to the payment table
        $payment = Payment::find($validated['payment_id']);
        $totalPaid = PaymentTransaction::where('payment_id', $validated['payment_id'])->sum('amount_paid');
        $totalDue = ($payment->amount_to_pay_for_the_special_trip ?? 0) +
                    ($payment->amount_to_pay_for_b2t ?? 0) +
                    ($payment->amount_to_pay_for_t2b ?? 0);

        $amountUnpaid = max($totalDue - $totalPaid, 0);
        $payment->amount_unpaid = $amountUnpaid;

        if($amountUnpaid == 0)
        {
            $payment->status = 'paid';
        }
        elseif($amountUnpaid == $totalDue)
        {
            $payment->status = 'un_paid';
        }
        else{
            $payment->status = 'partially_paid';
        }

        $payment->save();

        return response()->json(
        [
                'message' => 'Transaction updated successfully',
                'paymentTransaction' => $paymentTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient'),
                'amount_paid' => $totalPaid
        ], 200);
    }


    public function show(PaymentTransaction $paymentTransaction)
    {
        return response()->json
        ([
            'message' => 'success',
            'paymentTransaction' => $paymentTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient')
        ]);
    }


    public function destroy(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient');

        $paymentTransaction->deleted_by = auth()->id();
        $paymentTransaction->save();

        $trashedPayment = $paymentTransaction;

        $paymentTransaction->delete();

        return response()->json
        ([
            'message' => 'Transaction deleted',
            'paymentTransaction' => $trashedPayment
        ]);
    }


    public function trashed()
    {
        $trashedTransactions = PaymentTransaction::onlyTrashed()
                        ->with('payment', 't2bClient', 'b2tClient', 'specialTripClient')
                        ->get();

        return response()->json
        ([
            'message' => 'success',
            'trashedTransactions' => $trashedTransactions
        ]);
    }


    public function restore($id)
    {
        $trashedTransaction = PaymentTransaction::onlyTrashed()->findOrFail($id);
        $trashedTransaction->restore();

        return response()->json(
         [
            'message' => 'Transaction restored successfully',
            'trashedPayment' => $trashedTransaction->load('payment', 't2bClient', 'b2tClient', 'specialTripClient'
        )], 200);
    }
}