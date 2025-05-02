<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryClient extends Model
{
    //
    protected $fillable = [
        'client_name',
        'phone'
    ];

    public function t2bTrips()
    {
        return $this->belongsToMany(T2bTrip::class, 't2b_trip_clients');
    }

    public function specialTrips()
    {
        return $this->belongsToMany(SpecialTrip::class, 'special_trip_clients');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
