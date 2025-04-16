<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientParticipation;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncome = ClientParticipation::sum('amount_paid');
        $totalExpenses = Expense::sum('amount');
        $profit = $totalIncome - $totalExpenses;

        return view('dashboard.index', compact('totalIncome', 'totalExpenses', 'profit'));
    }
}

