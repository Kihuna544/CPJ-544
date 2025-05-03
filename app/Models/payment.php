<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable =[
        'client_id',
        'temporary_client_id',
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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function temporaryClients()
    {
        return $this->belongsTo(TemporaryClient::class);
    }

    public function t2bClients()
    {
        return $this->belongsTo(T2bClient::class);
    }

    public function b2tClients()
    {
        return $this->belongsTo(B2tClient::class);
    }

    public function specialTripClients()
    {
        return $this->belongsTo(SpecialTripClient::class);
    }
}
