<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'clients';

    protected $fillable = [
        'client_name',
        'phone',
        'profile_photo',
        'created_by',
        'deleted_by',
        'updated_by',
    ];


    public function b2tClients()
    {
        return $this->hasMany(B2tTripClient::class, 'client_id');
    }

}
