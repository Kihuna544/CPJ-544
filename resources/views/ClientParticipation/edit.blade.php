@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Edit Client Participation</h2>

    <form action="{{ route('participations.update', $participation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="trip_id" class="form-label">Trip</label>
            <select name="trip_id" id="trip_id" class="form-control @error('trip_id') is-invalid @enderror">
                <option value="">Select a Trip</option>
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}" {{ $trip->id == $participation->trip_id ? 'selected' : '' }}>
                        {{ $trip->destination }} - {{ $trip->trip_date }}
                    </option>
                @endforeach
            </select>
            @error('trip_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="client_id" class="form-label">Client</label>
            <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror">
                <option value="">Select a Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $client->id == $participation->client_id ? 'selected' : '' }}>
                        {{ $client->name }} ({{ $client->business_name }})
                    </option>
                @endforeach
            </select>
            @error('client_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="sacks_carried" class="form-label">Sacks Carried</label>
            <input type="number" name="sacks_carried" id="sacks_carried" class="form-control @error('sacks_carried') is-invalid @enderror" value="{{ old('sacks_carried', $participation->sacks_carried) }}">
            @error('sacks_carried') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="amount_to_pay" class="form-label">Amount to Pay</label>
            <input type="number" step="0.01" name="amount_to_pay" id="amount_to_pay" class="form-control @error('amount_to_pay') is-invalid @enderror" value="{{ old('amount_to_pay', $participation->amount_to_pay) }}">
            @error('amount_to_pay') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="amount_paid" class="form-label">Amount Paid</label>
            <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control @error('amount_paid') is-invalid @enderror" value="{{ old('amount_paid', $participation->amount_paid) }}">
            @error('amount_paid') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Participation</button>
    </form>
</div>
@endsection
