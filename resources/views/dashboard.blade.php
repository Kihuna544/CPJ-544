@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-5">🚚 CPJ544 Admin Dashboard</h2>

    <div class="row g-4">
        <!-- Financial Cards -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-white bg-success">
                <div class="card-body text-center">
                    <i class="fas fa-coins fa-2x mb-3"></i>
                    <h5>Total Income</h5>
                    <h3>₦{{ number_format($totalIncome, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-white bg-danger">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill-wave fa-2x mb-3"></i>
                    <h5>Total Expenses</h5>
                    <h3>₦{{ number_format($totalExpenses, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-white bg-primary">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-3"></i>
                    <h5>Profit</h5>
                    <h3>₦{{ number_format($profit, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- More Stats -->
    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-route fa-2x text-secondary mb-2"></i>
                    <h6>Total Trips</h6>
                    <h4>{{ $totalTrips }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-secondary mb-2"></i>
                    <h6>Total Clients</h6>
                    <h4>{{ $totalClients }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-id-card-alt fa-2x text-secondary mb-2"></i>
                    <h6>Total Drivers</h6>
                    <h4>{{ $totalDrivers }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Trips Table -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-clock"></i> Recent Trips</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Driver</th>
                                <th>Client(s)</th>
                                <th>Sacks</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTrips as $trip)
                                <tr>
                                    <td>{{ $trip->trip_date }}</td>
                                    <td>{{ $trip->driver->name }}</td>
                                    <td>
                                        @foreach($trip->clients as $client)
                                            <span class="badge bg-secondary">{{ $client->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $trip->total_sacks }}</td>
                                    <td>₦{{ number_format($trip->total_paid, 2) }}</td>
                                    <td>₦{{ number_format($trip->total_balance, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $trip->status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($trip->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No recent trips available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
