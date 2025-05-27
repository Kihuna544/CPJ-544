<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B2tTrip extends Model
{
    //
    protected $table = 'b2t_trips_table';
    
    protected $fillable = [
        'driver_id',
        'trip_date',
        'total_number_of_sacks',
        'total_number_of_packages',
        'created_by',
        'updated_by',
    ];

    public function b2tTripClients()
    {
        return $this->hasMany(B2tTripClient::class, 'b2t_trip_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
