<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class B2tTripClient extends Model
{
    //

    use SoftDeletes;

    protected $table = 'b2t_trip_clients';

    protected $fillable= [
        'b2t_trip_id',
        'client_id',
        'client_name',
        'no_of_sacks_per_client',
        'no_of_packages_per_client',
        'amount_to_pay_for_b2t',
        'created_by',
        'deleted_by',
        'updated_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function b2tTrip()
    {
        return $this->belongsTo(B2tTrip::class, 'b2t_trip_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'b2t_trip_client_id');
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class, 'b2t_client_payment_id');
    }
}
