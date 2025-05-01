<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = ['client_name', 'phone', 'profile_photo'];

    public function trips()
{
    return $this->belongsToMany(Trip::class);
}
public function participations()
{
    return $this->hasMany(ClientParticipation::class);
}


}
