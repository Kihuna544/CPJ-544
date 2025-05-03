<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'trip_date',
        'trip_type',
        'parent_trip_id',
        'direction',
        'trip_details',
    ];




    // A trip may belong to a driver
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }





    // If this is a child trip (T2B or B2T), it belongs to a parent trip
    public function parentTrip()
    {
        return $this->belongsTo(Trip::class, 'parent_trip_id');
    }

    // If this is a parent trip (normal), it has many children (T2B and B2T)
    public function childTrips()
    {
        return $this->hasMany(Trip::class, 'parent_trip_id');
    }





    // Helper to get the first T2B child trip of a normal trip
    public function t2bChild()
    {
        return $this->childTrips()->where('direction', 't2b')->first();
    }

    // Helper to get the first B2T child trip of a normal trip
    public function b2tChild()
    {
        return $this->childTrips()->where('direction', 'b2t')->first();
    }





    // Helper to check if this trip is a parent trip
    public function isParent()
    {
        return is_null($this->parent_trip_id);
    }

    // Helper to check if this trip is a T2B
    public function isT2b()
    {
        return $this->direction === 't2b';
    }

    // Helper to check if this trip is a B2T
    public function isB2t()
    {
        return $this->direction === 'b2t';
    }



    
    // Scope: get only parent trips (normal trips)
    public function scopeParentTrips($query)
    {
        return $query->whereNull('parent_trip_id');
    }

    // Scope: get only T2B trips
    public function scopeT2bTrips($query)
    {
        return $query->where('direction', 't2b');
    }

    // Scope: get only B2T trips
    public function scopeB2tTrips($query)
    {
        return $query->where('direction', 'b2t');
    }

    // Scope: get only special trips
    public function scopeSpecialTrips($query)
    {
        return $query->where('trip_type', 'special');
    }
}
