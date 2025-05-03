<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T2bTrips extends Model
{
    //
    protected $fillable = [
        'driver_id',
        'trip_date',
        'created_by',    
        'updated_by',

    ];


    public function drivers()
    {
        return this->belongsTo(Driver::class);
    }

    public function t2bClients()
    {
        return $this->belongsTo(TemporaryClient::class ,'t2b_trip_clients');
    }

    public function t2bClientItems()
    {
        return $this->hasMany(T2bClientItem::class);
    }
}
