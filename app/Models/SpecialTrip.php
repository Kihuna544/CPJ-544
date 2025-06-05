<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialTrip extends Model
{
    //
    use SoftDeletes;

    protected $table = 'special_trips';

    protected $fillable = [
        'driver_id',
        'trip_date',
        'trip_destination',
        'created_by',
        'deleted_by',
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
