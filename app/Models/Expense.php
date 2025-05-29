<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = 
    [
        'expense_date',
        'trip_id',
        'category',
        'amount',
        'notes',
        'created_by',
        'updated_by'
    ];


    public function trip()
    {
        return $this->hasMany(Trips::class, 'trip_id');
    }
}