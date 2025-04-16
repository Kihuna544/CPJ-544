@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Trip</h2>

    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="driver_id">Driver</label>
            <select name="driver_id" class="form-control" required>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-2">
            <label for="trip_date">Trip Date</label>
            <input type="date" name="trip_date" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="form-group mt-2">
            <label for="notes">Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-success mt-3">Save Trip</button>
    </form>
</div>
@endsection
