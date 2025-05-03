<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTrip extends Model
{
    //
    protected $fillable = [
        'driver_id',
        'client_id',
        'trip_date',
        'trip_destination',
        'trip_status',
        'created_by',
        'updated_by',
    ];

    public function specialTripClients()
    {
        return $this->belongsToMany(TemporaryClient::class, 'special_trip_clients');
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class);
    }

    public function specialTripItems()
    {
        return $this->hasMany(SpecialTripItem::class);
    }
}
