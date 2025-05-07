<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $table = 'clients';

    protected $fillable = [
        'client_name',
        'phone',
        'profile_photo',
    ];


    public function b2tClients()
    {
        return $this->hasMany(B2tTripClient::class, 'client_id');
    }

}
