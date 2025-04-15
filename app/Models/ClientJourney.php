<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientJourney extends Model
{
    protected $fillable = [
        'client_id',
        'journey_id',
        'sacks_carried',
        'amount_to_be_paid',
        'amount_paid',
        'remaining_balance'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }
}

