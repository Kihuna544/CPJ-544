@extends('layouts.app') {{-- Or your main layout --}}

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Trips</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('trips.create') }}" class="btn btn-primary mb-3">Add New Trip</a>

    @if($trips->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Driver</th>
                        <th>Clients</th>
                        <th>Date</th>
                        <th>Destination</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $trip->driver->name ?? 'N/A' }}</td>
                            <td>
                                @foreach($trip->clients as $client)
                                    <span class="badge bg-info text-dark">{{ $client->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $trip->trip_date }}</td>
                            <td>{{ $trip->destination }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">No trips found.</div>
    @endif
</div>
@endsection
