<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2tClient extends Model
{
    //
    protected $table = 'b2t_trip_clients';

    protected $fillable= [
        'b2t_trip_id',
        'client_id',
        'client_name',
        'no_of_sacks_per_client',
        'no_of_packages_per_client',
        'amount_to_pay_for_b2t',
        'created_by',
        'updated_by',
    ];

    public function b2tClient()
    {
        return $this->belongsToMany(Client::class, 'b2t_trip_clients');
    }

    public function b2tTrip()
    {
        return $this->belongsTo(B2tTrip::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }
}
