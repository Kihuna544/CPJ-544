<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class NormalItenkaTrip extends Model
{
    use SoftDeletes; 

    protected $table = 'normal_itenka_trips';

    protected $fillable = [
        'driver_id',
        'trip_date',
        'trip_details',
        'created_by',
        'deleted_by',
        'updated_by'
    ];




    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function t2bTrips()
    {
        return $this->hasMany(T2bTrip::class, 'normal_trip_id');
    }

    public function b2tTrips()
    {
        return $this->hasMany(B2tTrip::class, 'normal_trip_id');
    }
    
    public function expenses()
    {
        return $this->HasMany(Expenses::class);
    }





   
}
