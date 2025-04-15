<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['client_id', 'journey_id', 'amount', 'payment_date', 'method', 'notes'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }
}
