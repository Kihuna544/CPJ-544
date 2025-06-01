<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OffDutyExpense extends Model
{
    //

    use SoftDeletes; 

    protected $table = 'off_duty_expenses';

    protected $fillable = [
        'expense_date',
        'category',
        'amount',
        'notes',
        'created_by',
        'deleted_by',
        'updated_by'
    ];
}