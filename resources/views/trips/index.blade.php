@extends('layouts.app')

@section('content')
    <h1>All Trips</h1>
    <a href="{{ route('trips.create') }}" class="btn btn-primary mb-3">Create New Trip</a>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Driver</th>
                <th>Status</th>
                <th>Sacks</th>
                <th>Amount Paid</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trips as $trip)
                <tr>
                    <td>{{ $trip->id }}</td>
                    <td>{{ $trip->trip_date }}</td>
                    <td>{{ $trip->driver->name }}</td>
                    <td>{{ ucfirst($trip->status) }}</td>
                    <td>{{ $trip->sacks_delivered }}</td>
                    <td>{{ number_format($trip->amount_paid, 2) }}</td>
                    <td>{{ number_format($trip->remaining_balance, 2) }}</td>
                    <td>
                        <a href="{{ route('trips.show', $trip) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('trips.edit', $trip) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
