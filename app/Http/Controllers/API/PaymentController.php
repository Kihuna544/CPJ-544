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
                $payment,
                'total_paid' => $payment->total_paid
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
            'amount_paid' => 'required|numeric|min:0',
            'amount_unpaid' => 'required|numeric|min:0',
            'status' => 'required|in:un_paid,partially_paid,paid',
            'notes' => 'nullable|string|max:10000'   
        ]);

        $validated['amount_paid']= $payment->total_paid; // amount paid from the getTotalPaidAttribute created in the Payment Model
        $amountUnpaid = null;
        $specialTripClient = null;
        $b2tTripClient = null;
        $t2bTripClient = null;  

        if(isset($validated['special_trip_client_id'])){

            $specialTripClient = SpecialTripClient::find($validated['special_trip_client_id']);

            $validated['client_name'] = $specialTripClient->client_name ?? 'Unknown Client';

            $validated['amount_unpaid'] = $validated['amount_to_pay_for_the_special_trip'] - $validated['amount_paid'];
        }

        elseif(isset($validated['t2b_trip_client_id']))
        {
            $t2bTripClient = T2bTripClient::find($validated['t2b_trip_client_id']);

            $validated['client_name'] = $t2bTripClient->client_name ?? 'Unknown Client';

            $validated['amount_unpaid'] = $validated['amount_to_pay_for_t2b'] - $validated['amount_paid'];
        }

        elseif(isset($validated['b2t_trip_client_id']))
        {
            $b2tTripClient = B2tTripClient::find($validated['b2t_trip_client_id']);

            $validated['client_name'] = $b2tTripClient->client_name ?? 'Unknown Client';

            $validated['amount_unpaid'] = $validated['amount_to_pay_for_b2t'] - $validated['amount_paid'];
        }

        $validated['created_by'] = auth()->id();
        $payment = Payment::create($validated);

        return response()->json($payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions'), 201);
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
            'amount_paid' => 'required|numeric|min:0',
            'amount_unpaid' => 'required|numeric|min:0',
            'status' => 'required|in:un_paid,partially_paid,paid',
            'notes' => 'required|string|max:10000'
        ]);

        $validated['amount_paid'] = $payment->total_paid; //  amount paid from the getTotalPaidAttribute created in the Payment Model
        $amountUnpaid = null;
        $specialTripClient = null;
        $t2bTripClient = null;
        $b2tTripClient = null;

        if(isset($validated['special_trip_client_id']))
        {
            $specialTripClient = SpecialTripClient::find($validated['special_trip_client_id']);

            $validated['client_name'] = $specialTripClient->client_name ?? 'Unknown Client';

            $validated['amount_unpaid'] = $validated['amount_to_pay_the_for_special_trip'] - $validated['amount_paid'];
        }

        elseif(isset($validated['t2b_trip_client_id']))
        {
            $t2bTripClient = T2bTripClient::find($validated['t2b_trip_client_id']);

            $validated['client_name'] = $t2bTripClient->client_name ?? 'Unknown Client';

            $validated['amount_unpaid'] = $validated['amount_to_pay_for_t2b'] - $validated['amount_paid'];
        }

        elseif(isset($validated['b2t_trip_client_id']))
        {
            $b2tTripClient = B2tTripClient::find($validated['b2t_trip_client_id']);

            $validated['client_name'] = $b2tTripClient->client_name ?? 'Unknown Client';

            $validated['amount_unpaid'] = $validated['amount_to_pay_for_b2t'] - $validated['amount_paid'];
        }

        $validated['created_by'] = auth()->id();
        $payment->update($validated);

        return response()->json($payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions'), 200);
    }


    public function show(Payment $payment)
    {
        return response()->json
        ([
            $payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions'),
            'total_paid' => $payment->total_paid
        ]);
    }


    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json
        ([
            'message' => 'Payment deleted succesfully',
            'payment' => $payment->load('t2bClient', 'b2tClient', 'specialTripClient', 'paymentTransactions'),
            'total_paid' => $payment->total_paid
        ]);
    }
}