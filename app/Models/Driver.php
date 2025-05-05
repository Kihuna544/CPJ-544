<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    //
    protected $table = 'drivers'; 
    
    protected $fillable = [
        'name',
        'phone',
        'license_number',
        'profile_photo',
    ];


    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function t2bTrips()
    {
        return $this->hasMany(T2bTrip::class);
    }

    public function b2tTrips()
    {
        return $this->hasMany(B2tTrip::class);
    }

    public function specialTrips()
    {
        return $this->hasMany(SpecialTrip::class);
    }


}
