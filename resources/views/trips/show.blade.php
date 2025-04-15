@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Trip #{{ $trip->id }} Details</h1>

    <p><strong>Driver:</strong> {{ $trip->driver->name }}</p>
    <p><strong>Date:</strong> {{ $trip->trip_date }}</p>
    <p><strong>Status:</strong> {{ $trip->status }}</p>

    <h2 class="text-lg font-semibold mt-4">Journeys:</h2>
    <ul class="list-disc pl-5">
        @foreach ($trip->journeys as $journey)
            <li>
                Type: {{ $journey->type }} - Status: {{ $journey->status }}
                (<a href="{{ route('journeys.edit', $journey) }}">Edit</a>)
            </li>
        @endforeach
    </ul>

    <a href="{{ route('trips.index') }}" class="btn mt-4">Back to Trips</a>
@endsection
