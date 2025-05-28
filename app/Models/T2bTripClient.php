<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T2bTripClient extends Model
{
    //
    protected $table = 't2b_trip_clients'; 

    protected $fillable = [
        't2b_trip_id',
        'client_id',
        'client_name',
        'amount_to_pay_for_t2b',
        'created_by',
        'updated_by',
    ];



    public function temporaryClient()
    {
        return $this->belongsTo(TemporaryClient::class ,'client_id');
    }
    
    public function t2bTrip()
    {
        return $this->belongsTo(T2bTrip::class, 't2b_trip_id');
    }


    public function clientItems()
    {
        return $this->hasMany(T2bClientItem::class, 't2b_client_id');
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class, 't2b_client_payment_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 't2b_trip_client_id');
    }


}
