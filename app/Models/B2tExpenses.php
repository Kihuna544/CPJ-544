<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2tExpenses extends Model
{
    //
    protected $table = 'b2t_expenses';
    
    protected $fillable = [
        'expense_date',
        'b2t_trip_id',
        'category',
        'amount',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function b2tTrip()
    {
        return $this->belongsTo(B2tTrip::class, 'b2t_trip_id');
    }
}
