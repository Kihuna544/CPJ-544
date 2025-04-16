@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Trip</h2>

    <form action="{{ route('trips.update', $trip->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="driver_id">Driver</label>
            <select name="driver_id" class="form-control" required>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ $trip->driver_id == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-2">
            <label for="trip_date">Trip Date</label>
            <input type="date" name="trip_date" class="form-control" value="{{ $trip->trip_date }}" required>
        </div>

        <div class="form-group mt-2">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ $trip->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ $trip->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ $trip->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="form-group mt-2">
            <label for="notes">Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3">{{ $trip->notes }}</textarea>
        </div>

        <button class="btn btn-primary mt-3">Update Trip</button>
    </form>
</div>
@endsection
