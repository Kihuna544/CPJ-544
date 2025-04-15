<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['business_name', 'phone', 'profile_photo'];

    public function trips()
{
    return $this->belongsToMany(Trip::class);
}

}
