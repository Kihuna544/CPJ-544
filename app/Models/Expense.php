<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['journey_id', 'category', 'amount', 'expense_date', 'notes'];

    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }
        public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

}
