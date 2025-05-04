<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    //
    protected $fillable = [
        'payment_id',
        'amount_paid',
        'payment_date',
        'method',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function payments()
    {
        return $this->belongsTo(Payment::class);
    }

    public function clients()
    {
        return $this->belongsTo(Client::class, 'payments');
    }

    public function temporaryClients()
    {
        return $this->belongsTo(TemporaryClient::class, 'payments');
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

