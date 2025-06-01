<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    //
    use SoftDeletes;

    protected $table = 'trip_expenses';

    protected $fillable = 
    [
        'expense_date',
        'trip_id',
        'category',
        'amount',
        'notes',
        'created_by',
        'deleted_by',
        'updated_by'
    ];


    public function trip()
    {
        return $this->belongsTo(Trips::class, 'trip_id');
    }
}