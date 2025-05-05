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

    public function b2tClient()
    {
        return $this->belongsTo(Client::class, 'b2t_trip_clients');
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class);
    }
}
