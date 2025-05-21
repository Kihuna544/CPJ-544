<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'payments';

    protected $fillable =[
        't2b_trip_client_id',
        'b2t_trip_client_id',
        'special_trip_client_id',
        'client_name',
        'amount_to_pay_for_the_special_trip',
        'amount_to_pay_for_b2t',
        'amount_to_pay_for_t2b',
        'amount_paid',
        'amount_unpaid',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];


    public function t2bClient()
    {
        return $this->belongsTo(T2bClient::class, 't2b_trip_client_id');
    }

    public function b2tClient()
    {
        return $this->belongsTo(B2tClient::class, 'b2t_trip_client_id');
    }

    public function specialTripClient()
    {
        return $this->belongsTo(SpecialTripClient::class, 'special_trip_client_id');
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class, 'payment_id');
    }

    public function getTotalPaidAttribute()
    {
        return $this->paymentTransactions->sum('amount_paid');
    }
}
