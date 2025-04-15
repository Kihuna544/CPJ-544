<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['driver_id', 'trip_date', 'status'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function journeys()
    {
        return $this->hasMany(Journey::class);
    }
}
