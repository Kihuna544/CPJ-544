<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'location', 'business_name'];

    public function trips()
{
    return $this->belongsToMany(Trip::class);
}

}
