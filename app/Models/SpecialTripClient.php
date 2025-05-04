<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTripClient extends Model
{
    //
    protected $fillable = [
        'special_trip_id',
        'client_id',
        'client_name',
        'amount_to_pay_for_the_special_trip',
        'created_by',
        'updated_by',
    ];

    public function specialTripClient()
    {
        return $this->belongsTo(TemporaryClient::class ,'special_trip_clients');
    }

    public function specialTrips()
    {
        return $this->belongsTo(SpecialTrip::class);
    }

    public function specialTripItems()
    {
        return $this->hasMany(SpecialTripItem::class);
        
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
