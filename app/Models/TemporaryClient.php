<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryClient extends Model
{
    //
    protected $fillable = [
        'client_name',
        'phone'
    ];

    public function t2bCLients()
    {
        return $this->hasMany(T2bClient::class, 'client_id');
    }

    public function specialTripClients()
    {
        return $this->hasMany(SpecialTripClient::class, 'client_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }
}
