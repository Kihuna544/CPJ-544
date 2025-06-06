<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\T2bTripClient;
use App\Models\B2tTripClient;
use App\Models\SpecialTripClient;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $payment = Payment::with('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions')
                ->latest()
                ->paginate($perPage);

        return response()->json
            ([
                'message' => 'success',
                'payments' =>$payment,
            ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate
        ([
            't2b_trip_client_id' => 'nullable|exists:t2b_trip_clients,id',
            'b2t_trip_client_id' => 'nullable|exists:b2t_trip_clients,id',
            'special_trip_client_id' => 'nullable|exists:special_trip_clients,id',
            'amount_to_pay_for_the_special_trip' => 'nullable|numeric|min:0',
            'amount_to_pay_for_b2t' => 'nullable|numeric|min:0',
            'amount_to_pay_for_t2b' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:10000'   
        ]);

        $totalDue = ($validated['amount_to_pay_for_the_special_trip'] ?? 0) +
                    ($validated['amount_to_pay_for_b2t'] ?? 0) +
                    ($validated['amount_to_pay_for_t2b'] ?? 0);


        $validated['amount_unpaid'] = $totalDue; // upon creating a new payment, i expect that no transaction is made

        $validated['status'] = 'un_paid';

        $validated['created_by'] = auth()->id();

        $payment = Payment::create($validated);

        return response()->json($payment->load
        ([
            'message' => 'Payment created successfully',
            'payment' => $payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions')
        ]), 201);
    }


    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate
        ([
            't2b_trip_client_id' => 'nullable|exists:t2b_trip_clients,id',
            'b2t_trip_client_id' => 'nullable|exists:b2t_trip_clients,id',
            'special_trip_client_id' => 'nullable|exists:special_trip_clients,id',
            'amount_to_pay_for_the_special_trip' => 'nullable|numeric|min:0',
            'amount_to_pay_for_b2t' => 'nullable|numeric|min:0',
            'amount_to_pay_for_t2b' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:10000'
        ]);

        $totalDue = ($validated['amount_to_pay_for_the_special_trip'] ?? $payment->amount_to_pay_for_the_special_trip ?? 0) +
                    ($validated['amount_to_pay_for_b2t'] ?? $payment->amount_to_pay_for_b2t ?? 0) +
                    ($validated['amount_to_pay_for_t2b'] ?? $payment->amount_to_pay_for_t2b ?? 0);

        $totalPaid = $payment->paymentTransactions()->sum('amount_paid');
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

        $validated['updated_by'] = auth()->id();
        $payment->update($validated);


        return response()->json
        ([
            'message' => 'Payment updated successfully',
            'payment' => $payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions')
        ]);
    }


    public function show(Payment $payment)
    {
        return response()->json
        ([
            'message' => 'success',
            'payment' => $payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions'),
        ]);
    }


    public function destroy(Payment $payment)
    {
        $payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions');

        $payment->deleted_by = auth()->id();
        $payment->save();

        $deletedPayment = $payment;

        $payment->delete();

        return response()->json
        ([
            'message' => 'Payment deleted successfully',
            'deletedPayment' => $deletedPayment,
        ]);
    }


    public function trashed()
    {
        $trashedPayment = Payment::onlyTrashed()
                        ->with('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions')
                        ->paginate($request->query('per_page', 10))
                        ->get();

        return response()->json
        ([
            'message' => 'success',
            'payment' => $payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions')
        ]);
    }


    public function restore($id)
    {
        $trashedPayment = Payment::onlyTrashed()->findOrFail($id);
        $trashedPayment->restore();

        return response()->json
        ([
            'message' => 'Payment record restored successfully',
            'trashedPayment' => $trashedPayment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions')
        ], 200);

    }
}