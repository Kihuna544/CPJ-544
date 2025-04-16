<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientParticipation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'client_id',
        'crop_type',
        'sacks_carried',
        'amount_to_pay',
        'amount_paid',
        'balance',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
