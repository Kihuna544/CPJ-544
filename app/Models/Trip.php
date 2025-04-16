<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['driver_id', 'trip_date', 'status'];
    protected $dates = ['trip_date'];


    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function journeys()
    {
        return $this->hasMany(Journey::class);
    }
    
    public function participations()
{
    return $this->hasMany(ClientParticipation::class);
}

}
