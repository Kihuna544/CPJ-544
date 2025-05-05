<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTripExpenses extends Model
{
    //
    protected $table = 'special_trip_expenses';
    
    protected $fillable = [
        'expense_date',
        'special_trip_id',
        'category',
        'amount',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function specialTrip()
    {
        return $this->belongsTo(SpecialTrip::class, 'special_trip_id');
    }
}
