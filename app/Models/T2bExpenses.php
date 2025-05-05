<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class T2bExpenses extends Model
{
    //
    protected $table = 't2b_expenses';

    protected $fillable = [
        'expense_date',
        't2b_trip_id',
        'category',
        'amount',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function t2bTrip()
    {
        return $this->belongsTo(T2bTrip::class, 't2b_trip_id');
    }
}
