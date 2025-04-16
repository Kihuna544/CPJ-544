@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4">Client Profile</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <strong>Name:</strong> {{ $client->name }}<br>
                <strong>Phone:</strong> {{ $client->phone }}<br>
                <strong>Location:</strong> {{ $client->location }}<br>
                <strong>Business:</strong> {{ $client->business_name }}<br>
            </div>
            <div class="col-md-6">
                <strong>Email:</strong> {{ $client->email }}<br>
                <strong>Total Sacks Carried:</strong> {{ $totalSacks }}<br>
                <strong>Total To Pay:</strong> GHS {{ number_format($totalToPay, 2) }}<br>
                <strong>Total Paid:</strong> GHS {{ number_format($totalPaid, 2) }}<br>
                <strong>Unpaid Balance:</strong> 
                <span class="{{ $totalBalance > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                    GHS {{ number_format($totalBalance, 2) }}
                </span><br>
                <strong>Crops Transported:</strong> {{ $cropTypes->implode(', ') }}
            </div>
        </div>

        <hr>

        <h5 class="mb-3">Participation History</h5>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Destination</th>
                    <th>Crop</th>
                    <th>Sacks</th>
                    <th>To Pay</th>
                    <th>Paid</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participations as $p)
                    <tr>
                        <td>{{ $p->trip->trip_date }}</td>
                        <td>{{ $p->trip->destination }}</td>
                        <td>{{ $p->crop_type ?? '-' }}</td>
                        <td>{{ $p->sacks_carried }}</td>
                        <td>GHS {{ number_format($p->amount_to_pay, 2) }}</td>
                        <td>GHS {{ number_format($p->amount_paid, 2) }}</td>
                        <td class="{{ $p->balance > 0 ? 'text-danger fw-bold' : '' }}">
                            GHS {{ number_format($p->balance, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
