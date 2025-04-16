<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'driver_id',
        'trip_date',
        'status',
        'notes',    
    ];

    protected $dates = ['trip_date'];

    // Driver assigned to this trip
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    // Journey segments within this trip
    public function journeys()
    {
        return $this->hasMany(Journey::class);
    }

    // Client participations on this trip
    public function clientParticipations()
    {
        return $this->hasMany(ClientParticipation::class);
    }

    // Direct access to all clients on this trip (via participations)
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_participations');
    }

    // Helper: total sacks from participations
    public function getTotalSacksAttribute()
    {
        return $this->participations->sum('sacks_carried');
    }

    // Helper: total amount paid from participations
    public function getTotalPaidAttribute()
    {
        return $this->participations->sum('amount_paid');
    }

    // Helper: total balance remaining from participations
    public function getTotalBalanceAttribute()
    {
        return $this->participations->sum('balance');
    }

        public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

}
