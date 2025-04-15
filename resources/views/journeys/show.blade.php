@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Journey #{{ $journey->id }}</h1>

    <p><strong>Trip:</strong> {{ $journey->trip_id }}</p>
    <p><strong>Type:</strong> {{ $journey->type }}</p>
    <p><strong>Status:</strong> {{ $journey->status }}</p>

    <a href="{{ route('journeys.index') }}" class="btn mt-4">Back to Journeys</a>
@endsection
