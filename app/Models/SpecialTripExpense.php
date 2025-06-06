<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialTripExpense extends Model
{
    //
    use SoftDeletes;

    protected $table = 'special_trip_expenses';
    
    protected $fillable = [
        'expense_date',
        'special_trip_id',
        'category',
        'amount',
        'notes',
        'created_by',
        'deleted_by',
        'updated_by',
    ];

    public function specialTrip()
    {
        return $this->belongsTo(SpecialTrip::class, 'special_trip_id');
    }
}
