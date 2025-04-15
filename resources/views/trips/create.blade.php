@extends('layouts.app')

@section('content')
    <h2>Create New Trip</h2>

    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="driver_id" class="form-label">Driver</label>
            <select name="driver_id" class="form-select" required>
                <option value="">-- Select Driver --</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="trip_date" class="form-label">Trip Date</label>
            <input type="date" name="trip_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="destination" class="form-label">Destination</label>
            <input type="text" name="destination" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="sacks_delivered" class="form-label">Sacks Delivered</label>
            <input type="number" name="sacks_delivered" class="form-control">
        </div>

        <div class="mb-3">
            <label for="amount_paid" class="form-label">Amount Paid</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control">
        </div>

        <div class="mb-3">
            <label for="remaining_balance" class="form-label">Remaining Balance</label>
            <input type="number" step="0.01" name="remaining_balance" class="form-control" value="0">
        </div>

        <button type="submit" class="btn btn-success">Create Trip</button>
    </form>
@endsection
