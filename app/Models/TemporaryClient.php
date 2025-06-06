<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TemporaryClient extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'temporary_clients';

    protected $fillable = [
        'client_name',
        'phone',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function t2bCLients()
    {
        return $this->hasMany(T2bClient::class, 'temporary_client_id');
    }

    public function specialTripClients()
    {
        return $this->hasMany(SpecialTripClient::class, 'temporary_client_id');
    }
}
