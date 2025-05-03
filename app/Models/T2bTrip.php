<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class T2bTrips extends Model
{
    //
    protected $fillable = [
        'driver_id',
        'trip_date',
        'created_by',    
        'updated_by',

    ];


    public function t2bclients()
    {
        return this->hasMany(T2bClients::class);
    }
}
