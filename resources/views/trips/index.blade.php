@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Trips</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('trips.create') }}" class="btn btn-primary mb-3">Add New Trip</a>

    @if($trips->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Driver</th>
                        <th>Clients & Amounts</th>
                        <th>Date</th>
                        <th>Destination</th>
                        <th>Total Delivery Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $trip->driver->name ?? '-' }}</td>
                            <td>
                                @forelse($trip->clients as $client)
                                    <div>
                                        <strong>{{ $client->name }}</strong><br>
                                        <small>Delivery: ${{ number_format($client->pivot->delivery_amount, 2) }}</small>
                                    </div>
                                @empty
                                    <span class="text-muted">No Clients</span>
                                @endforelse
                            </td>
                            <td>{{ \Carbon\Carbon::parse($trip->trip_date)->format('d M Y') }}</td>
                            <td>{{ $trip->destination }}</td>
                            <td>
                                ${{ number_format($trip->clients->sum(fn($c) => $c->pivot->delivery_amount), 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">No trips found.</div>
    @endif
</div>
@endsection
