<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Dashboard Cards -->
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5>Total Clients</h5>
                    <h2>{{ $totalClients }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5>Total Trips Today</h5>
                    <h2>{{ $totalTripsToday }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5>Total Revenue</h5>
                    <h2>${{ $totalRevenue }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5>Total Expenses</h5>
                    <h2>${{ $totalExpenses }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Trips -->
        <div class="col-md-12">
            <h3>Recent Trips</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
                            <th>Driver</th>
                            <th>Client</th>
                            <th>Total Sacks</th>
                            <th>Total Paid</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentTrips as $trip)
                        <tr>
                            <td>{{ $trip->id }}</td>
                            <td>{{ $trip->driver->name }}</td>
                            <td>{{ $trip->clients->pluck('name')->join(', ') }}</td>
                            <td>{{ $trip->total_sacks }}</td>
                            <td>${{ $trip->total_paid }}</td>
                            <td>${{ $trip->total_balance }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
