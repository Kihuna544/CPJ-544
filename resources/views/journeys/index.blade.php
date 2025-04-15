@extends('layouts.app')

@section('content')
    <h1>All Journeys</h1>
    <a href="{{ route('journeys.create') }}" class="btn btn-primary mb-3">Add Journey</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Trip ID</th>
                <th>Type</th>
                <th>Start</th>
                <th>End</th>
                <th>Driver</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($journeys as $journey)
                <tr>
                    <td>{{ $journey->id }}</td>
                    <td>{{ $journey->trip_id }}</td>
                    <td>{{ $journey->type }}</td>
                    <td>{{ $journey->start_location }}</td>
                    <td>{{ $journey->end_location }}</td>
                    <td>{{ $journey->driver->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
