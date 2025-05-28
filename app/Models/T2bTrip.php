<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T2bTrip extends Model
{
    //
    protected $table = 't2b_trips_table';

    protected $fillable = [
        'driver_id',
        'trip_date',
        'created_by',    
        'updated_by',

    ];


    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function t2bTripClients()
    {
        return $this->hasMany(T2bTripClient::class ,'t2b_trip_id');
    }

    public function t2bClientItems()
    {
        return $this->hasMany(T2bClientItem::class, 't2b_trip_id');
    }


}
