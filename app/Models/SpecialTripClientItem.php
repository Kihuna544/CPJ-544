<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTripClientItem extends Model
{
    //
    protected $table = 'special_trip_items';

    protected $fillable =  [
        'special_trip_id',
        'special_trip_client_id',
        'item_name',
        'quantity',
        'created_by',
        'updated_by',
    ];

    public function specialTripClient()
    {
        return $this->belongsTo(SpecialTripClient::class, 'special_trip_client_id');
    }

    public function specialTrip()
    {
        return $this->belongsTo(SpecialTrip::class, 'special_trip_id');
    }
}
