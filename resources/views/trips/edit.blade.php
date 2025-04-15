@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Edit Trip</h1>

    <form action="{{ route('trips.update', $trip) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Driver:</label>
        <select name="driver_id" class="block w-full mb-2">
            @foreach ($drivers as $driver)
                <option value="{{ $driver->id }}" {{ $trip->driver_id == $driver->id ? 'selected' : '' }}>
                    {{ $driver->name }}
                </option>
            @endforeach
        </select>

        <label>Date:</label>
        <input type="date" name="trip_date" value="{{ $trip->trip_date }}" class="block w-full mb-2">

        <label>Status:</label>
        <select name="status" class="block w-full mb-2">
            <option value="pending" {{ $trip->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ $trip->status == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <button class="btn btn-primary">Update Trip</button>
    </form>
@endsection
