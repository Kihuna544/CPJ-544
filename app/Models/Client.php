<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'client_name',
        'phone',
        'profile_photo',
    ];


    public function b2tTrips()
    {
        return $this->belongsToMany(B2tTrip::class, 'b2t_trip_clients');
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
