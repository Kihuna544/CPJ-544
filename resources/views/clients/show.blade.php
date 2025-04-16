@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: url('/images/background.jpg'); /* replace with your image */
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    .card {
        background-color: rgba(255, 255, 255, 0.95);
    }
</style>

<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4">Client Profile: {{ $client->name }}</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Phone:</strong> {{ $client->phone }}</p>
                <p><strong>Email:</strong> {{ $client->email }}</p>
                <p><strong>Business:</strong> {{ $client->business_name }}</p>
                <p><strong>Location:</strong> {{ $client->location }}</p>
            </div>
        </div>

        <h4 class="mb-3">Trip Participation History</h4>

        <table class="table table-bordered table-hover bg-white">
            <thead class="table-primary">
                <tr>
                    <th>Date</th>
                    <th>Trip Destination</th>
                    <th>Crop Type</th>
                    <th>Sacks</th>
                    <th>To Pay</th>
                    <th>Paid</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participations as $participation)
                    <tr>
                        <td>{{ $participation->trip->trip_date->format('d M Y') }}</td>
                        <td>{{ $participation->trip->destination }}</td>
                        <td>{{ $participation->crop_type ?? 'N/A' }}</td>
                        <td>{{ $participation->sacks_carried }}</td>
                        <td>{{ number_format($participation->amount_to_pay, 2) }}</td>
                        <td>{{ number_format($participation->amount_paid, 2) }}</td>
                        <td class="{{ $participation->balance > 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($participation->balance, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No participations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
