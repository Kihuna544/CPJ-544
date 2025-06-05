<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\ELoquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class T2bTrip extends Model
{
    //
    use SofDeletes;

    protected $table = 't2b_trips_table';

    protected $fillable = [
        'normal_trip_id',
        'created_by', 
        'deleted_by',   
        'updated_by',

    ];


    public function trip()
    {
        return $this->belongsTo(NormalItenkaTrip::class, 'normal_trip_id');
    }

    public function t2bTripClients()
    {
        return $this->hasMany(T2bTripClient::class ,'t2b_trip_id');
    }

    public function t2bClientItems()
    {
        return $this->hasMany(T2bClientItem::class, 't2b_trip_id');
    }


}
