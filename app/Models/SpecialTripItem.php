<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTripItem extends Model
{
    //
    protected $fillable = [
        'special_trip_client_id',
        'item_name',
        'quantity',
        'created_by',
        'updated_by',
    ];

    public function specialTripClients()
    {
        return $this->belongsTo(TemporaryClient::class, 'special_trip_clients');
    }

    public function specialTrips()
    {
        return $this->belongsTo(SpecialTrip::class);
    }
}
