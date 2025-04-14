@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Client Profile</h2>

    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title">{{ $client->name }}</h4>
            <p><strong>Phone:</strong> {{ $client->phone }}</p>
            <p><strong>Address:</strong> {{ $client->address }}</p>
            <p><strong>Email:</strong> {{ $client->email ?? 'N/A' }}</p>
            <p><strong>Balance:</strong> Tsh {{ number_format($client->balance, 2) }}</p>

            <a href="{{ route('clients.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection
