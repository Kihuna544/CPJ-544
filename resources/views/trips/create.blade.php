@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Create a New Trip</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="driver_id" class="form-label">Select Driver</label>
            <select class="form-select" name="driver_id" id="driver_id" required>
                <option value="">-- Select Driver --</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="trip_date" class="form-label">Trip Date</label>
            <input type="date" class="form-control" name="trip_date" required>
        </div>

        <div class="mb-3">
            <label for="destination" class="form-label">Destination</label>
            <input type="text" class="form-control" name="destination" required>
        </div>

        <h5 class="mb-3">Clients</h5>
        <div id="clients-section">
            <div class="row g-2 mb-2 client-row">
                <div class="col-md-6">
                    <select name="clients[0][client_id]" class="form-select" required>
                        <option value="">-- Select Client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="clients[0][delivery_amount]" class="form-control" placeholder="Delivery Amount" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger w-100" onclick="removeClientRow(this)">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addClientRow()">Add Another Client</button>

        <button type="submit" class="btn btn-success">Submit Trip</button>
    </form>
</div>

<script>
    let clientIndex = 1;

    function addClientRow() {
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 client-row';
        row.innerHTML = `
            <div class="col-md-6">
                <select name="clients[${clientIndex}][client_id]" class="form-select" required>
                    <option value="">-- Select Client --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="clients[${clientIndex}][delivery_amount]" class="form-control" placeholder="Delivery Amount" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100" onclick="removeClientRow(this)">Remove</button>
            </div>
        `;
        document.getElementById('clients-section').appendChild(row);
        clientIndex++;
    }

    function removeClientRow(button) {
        button.closest('.client-row').remove();
    }
</script>
@endsection
