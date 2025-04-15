@extends('layouts.app')

@section('content')
    <h2>Create Journey</h2>

    <form action="{{ route('journeys.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="trip_id" class="form-label">Trip</label>
            <select name="trip_id" class="form-select">
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}">Trip #{{ $trip->id }} ({{ $trip->trip_date }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Journey Type</label>
            <select name="type" class="form-select">
                <option value="T2B">Town to Bush</option>
                <option value="B2T">Bush to Town</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="start_location" class="form-label">Start Location</label>
            <input type="text" name="start_location" class="form-control">
        </div>

        <div class="mb-3">
            <label for="end_location" class="form-label">End Location</label>
            <input type="text" name="end_location" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Add Journey</button>
    </form>
@endsection
