<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialTripClientItem extends Model
{
    //
    use SoftDeletes;

    protected $table = 'special_trip_items';

    protected $fillable =  [
        'special_trip_id',
        'special_trip_client_id',
        'item_name',
        'quantity',
        'created_by',
        'deleted_by',
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
