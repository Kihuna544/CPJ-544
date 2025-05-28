<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T2bClientItem extends Model
{
    protected $table = 't2b_trips_items';
    
    protected $fillable =
     [
        't2b_client_id',
        't2b_trip_id',
        'item_name',
        'quantity',
        'created_by',
        'updated_by',
    ];


    public function t2bClient()
    {
        return $this->belongsTo(T2bClient::class, 't2b_client_id');
    }

    public function t2bTrip()
    {
        return $this->belongsTo(T2bTrip::class, 't2b_trip_id');
    }
}
