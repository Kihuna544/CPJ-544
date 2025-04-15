<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'phone', 'license_number'];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
