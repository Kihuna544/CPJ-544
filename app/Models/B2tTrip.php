<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B2tTrip extends Model
{
    //
    use SoftDeletes;

    protected $table = 'b2t_trips_table';
    
    protected $fillable = [
        'normal_trip_id',
        'total_number_of_sacks',
        'total_number_of_packages',
        'created_by',
        'deleted_by',
        'updated_by',
    ];

    public function trip()
    {
        return $this->belongsTO(NormalItenkaTrip::class, 'normal_trip_id');
    }

    public function b2tTripClients()
    {
        return $this->hasMany(B2tTripClient::class, 'b2t_trip_id');
    }
    
    public function refreshTotals()
    {
        $this->update
        ([
            'total_number_of_sacks' => $this->b2tTripClients()->sum('no_of_sacks_per_client'),
            'total_number_of_packages' => $this->b2tTripClients()->sum('no_of_packages_per_client')
        ]);
    }
}
