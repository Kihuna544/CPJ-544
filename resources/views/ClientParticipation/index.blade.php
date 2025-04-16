@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Client Participation List</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('participations.create') }}" class="btn btn-primary">Add New Participation</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Trip Date</th>
                <th>Destination</th>
                <th>Sacks Carried</th>
                <th>Amount to Pay</th>
                <th>Amount Paid</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participations as $participation)
                <tr>
                    <td>{{ $participation->client->name }}</td>
                    <td>{{ $participation->trip->trip_date }}</td>
                    <td>{{ $participation->trip->destination }}</td>
                    <td>{{ $participation->sacks_carried }}</td>
                    <td>{{ number_format($participation->amount_to_pay, 2) }}</td>
                    <td>{{ number_format($participation->amount_paid, 2) }}</td>
                    <td>{{ number_format($participation->balance, 2) }}</td>
                    <td>
                        <a href="{{ route('participations.edit', $participation->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('participations.destroy', $participation->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this participation?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $participations->links() }}
    </div>
</div>
@endsection
