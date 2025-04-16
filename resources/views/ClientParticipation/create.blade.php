@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow p-4">
        <h2 class="mb-4">Add Client Participation</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('participations.store') }}">
            @csrf

            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select name="client_id" id="client_id" class="form-select" required>
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                <div class="form-text text-danger" id="balance-display" style="font-weight: bold;"></div>
            </div>

            <div class="mb-3">
                <label for="trip_id" class="form-label">Trip</label>
                <select name="trip_id" class="form-select" required>
                    <option value="">Select Trip</option>
                    @foreach($trips as $trip)
                        <option value="{{ $trip->id }}">{{ $trip->trip_date }} - {{ $trip->destination }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="crop_type" class="form-label">Crop Type</label>
                <input type="text" name="crop_type" class="form-control">
            </div>

            <div class="mb-3">
                <label for="sacks_carried" class="form-label">Sacks Carried</label>
                <input type="number" name="sacks_carried" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="amount_to_pay" class="form-label">Amount to Pay</label>
                <input type="number" step="0.01" name="amount_to_pay" class="form-control" id="amount_to_pay" required>
            </div>

            <div class="mb-3">
                <label for="amount_paid" class="form-label">Amount Paid</label>
                <input type="number" step="0.01" name="amount_paid" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Participation</button>
        </form>
    </div>
</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#client_id').on('change', function () {
        var clientId = $(this).val();
        if (clientId) {
            $.get('/clients/' + clientId + '/latest-balance', function (data) {
                $('#balance-display').text('Unpaid from last trip: ' + data.balance.toFixed(2));
            });
        } else {
            $('#balance-display').text('');
        }
    });
</script>
@endsection
