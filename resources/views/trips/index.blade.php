@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Trips</h2>
    <a href="{{ route('trips.create') }}" class="btn btn-primary mb-3">Add New Trip</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Driver</th>
                <th>Trip Date</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
                <tr>
                    <td>{{ $trip->id }}</td>
                    <td>{{ $trip->driver->name }}</td>
                    <td>{{ $trip->trip_date }}</td>
                    <td>{{ ucfirst($trip->status) }}</td>
                    <td>{{ $trip->notes }}</td>
                    <td>
                        <a href="{{ route('trips.edit', $trip->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this trip?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $trips->links() }}
</div>
@endsection
