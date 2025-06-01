<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffDutyExpense extends Model
{
    protected $table = 'off_duty_expenses';

    protected $fillabe = [
        'expense_date',
        'category',
        'amount',
        'notes',
        'created_by',
        'updated_by'
    ];
}