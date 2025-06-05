<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'payment_transactions';

    protected $fillable = [
        'payment_id',
        't2b_client_payment_id',
        'b2t_client_payment_id',
        'special_trip_client_payment_id',
        'amount_paid',
        'payment_date',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }


    public function t2bClient()
    {
        return $this->belongsTo(T2bClient::class, 't2b_client_payment_id');
    }

    public function b2tClient()
    {
        return $this->belongsTo(B2tClient::class, 'b2t_client_payment_id');
    }

    public function specialTripClient()
    {
        return $this->belongsTo(SpecialTripClient::class, 'special_trip_client_payment_id');
    }
}

