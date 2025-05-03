<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    //
    protected $fillable = [
        'expense_date',
        'trip_id',
        'category',
        'amount',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function trips()
    {
        return $this->belongsTo(Trip::class);
    }
}
