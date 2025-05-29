<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTrip extends Model
{
    //
    protected $table = 'special_trips';

    protected $fillable = [
        'driver_id',
        'client_id',
        'trip_date',
        'trip_destination',
        'trip_status',
        'created_by',
        'updated_by',
    ];


    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }

    public function specialTripItems()
    {
        return $this->hasMany(SpecialTripItem::class, 'special_trip_id');
    }

    public function specialTripClients()
    {
        return $this->hasMany(SpecialTripClient::class, 'special_trip_id');
    }
}
