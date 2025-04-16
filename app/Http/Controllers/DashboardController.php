<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Client;
use App\Models\User;
use App\Models\Driver;
use App\Models\Expense;
use App\Models\ClientParticipation;

class DashboardController extends Controller
{
    public function index()
    {
        // Financials
        $totalIncome = ClientParticipation::sum('amount_paid');
        $totalExpenses = Expense::sum('amount');
        $profit = $totalIncome - $totalExpenses;

        // Stats
        $totalTrips = Trip::count();
        $totalDrivers = Driver::count();
        $totalClients = Client::count();

        // Recent Trips with client and driver relationships
        $recentTrips = Trip::with(['driver', 'clients'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($trip) {
                $trip->total_sacks = $trip->clientParticipations->sum('sacks_carried');
                $trip->total_paid = $trip->clientParticipations->sum('amount_paid');
                $trip->total_balance = $trip->clientParticipations->sum('balance');
                return $trip;
            });

        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses',
            'profit',
            'totalTrips',
            'totalClients',
            'totalDrivers',
            'recentTrips'
        ));
    }
}
