<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTripClient extends Model
{
    //
    protected $table = 'special_trip_clients';

    protected $fillable = [
        'special_trip_id',
        'client_id',
        'client_name',
        'amount_to_pay_for_the_special_trip',
        'created_by',
        'updated_by',
    ];

    public function client()
    {
        return $this->belongsTo(TemporaryClient::class ,'client_id');
    }

    public function specialTrip()
    {
        return $this->belongsTo(SpecialTrip::class, 'special_trip_id');
    }

    public function specialTripClientItems()
    {
        return $this->hasMany(SpecialTripClientItem::class, 'special_trip_client_id');
        
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'special_trip_client_id');
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class, 'special_trip_client_payment_id');
    }
}
