<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $fillable = ['trip_id', 'direction', 'destination'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function clientJourneys()
    {
        return $this->hasMany(ClientJourney::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_journeys')
                    ->withPivot(['sacks_carried', 'amount_to_be_paid', 'amount_paid', 'remaining_balance']);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
