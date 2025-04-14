<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{

    protected $fillable = [
        'driver_id',
        'client_id',
        'trip_date',
        'destination',
        'sacks_delivered',
        'amount_paid',
        'remaining_balance',
        'status',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class)->withPivot('amount_paid');
    }

}
