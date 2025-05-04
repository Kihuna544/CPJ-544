<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T2bClient extends Model
{
    //
    protected $fillable = [
        't2b_trip_id',
        'client_id',
        'client_name',
        'amount_to_pay_for_t2b',
        'created_by',
        'updated_by',
    ];



    public function t2bClients()
    {
        return $this->belongsToMany(TemporaryClient::class ,'t2b_client_table');
    }
    
    public function t2bTrips()
    {
        return $this->hasMany(T2bTrip::class);
    }


    public function clientItem()
    {
        return $this->hasMany(T2bClientItem::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


}
