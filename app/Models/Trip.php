<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
    public $function = [
        'driver_id',
        'trip_date',
        'trip_type',
        'parent_trip_id',
        'direction',
        'trip_details',
    ];
}
