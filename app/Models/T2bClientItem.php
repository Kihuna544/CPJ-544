<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class T2bClientItem extends Model
{
    protected $filllable =
     [
        'client_id',
        't2b_trip_id',
        'quantity',
        'created_by',
        'updated_by',
    ];


    public function t2bClients()
    {
        return $this->belongsTo(TemporaryClient::class, 't2b_trip_clients');
    }

    public function t2bTrips()
    {
        return $this->belongsTo(T2bTrip::class);
    }
}
