@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create New Trip</h2>

    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        {{-- Select Driver --}}
        <div class="mb-3">
            <label for="driver_id" class="form-label">Driver</label>
            <select class="form-select" id="driver_id" name="driver_id" required>
                <option value="">Select Driver</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Trip Date --}}
        <div class="mb-3">
            <label for="trip_date" class="form-label">Trip Date</label>
            <input type="date" class="form-control" name="trip_date" id="trip_date" required>
        </div>

        {{-- Destination --}}
        <div class="mb-3">
            <label for="destination" class="form-label">Destination</label>
            <input type="text" class="form-control" name="destination" id="destination" required>
        </div>

        {{-- Clients Section --}}
        <div class="mb-4">
            <label class="form-label">Add Clients</label>
            <div class="row align-items-end">
                <div class="col-md-6">
                    <select id="client_selector" class="form-select">
                        <option value="">-- Select Client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" id="delivery_amount" placeholder="Delivery Amount">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-success" onclick="addClient()">Add Client</button>
                </div>
            </div>
        </div>

        {{-- Added Clients Preview --}}
        <div id="clients-list" class="mb-4">
            <h5>Clients for this Trip</h5>
            <ul class="list-group" id="selected-clients"></ul>
        </div>

        <input type="hidden" name="clients_data" id="clients_data">

        <button type="submit" class="btn btn-primary">Submit Trip</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let selectedClients = [];

    function addClient() {
        const clientId = document.getElementById('client_selector').value;
        const clientName = document.getElementById('client_selector').selectedOptions[0].text;
        const amount = document.getElementById('delivery_amount').value;

        if (!clientId || !amount) return alert("Please select a client and set the delivery amount");

        // Prevent duplicates
        if (selectedClients.some(c => c.client_id == clientId)) {
            alert('Client already added.');
            return;
        }

        // Fetch payment info and then add to list
        fetch(`/clients/${clientId}/payment-status?amount=${amount}`)
            .then(res => res.json())
            .then(data => {
                selectedClients.push({
                    client_id: clientId,
                    delivery_amount: amount,
                    unpaid_amount: data.unpaid_amount,
                    total_to_pay: parseFloat(data.unpaid_amount) + parseFloat(amount),
                    last_payment_date: data.last_payment_date,
                    last_payment_amount: data.last_payment_amount,
                    name: clientName
                });

                renderClients();
            });
    }

    function renderClients() {
        const ul = document.getElementById('selected-clients');
        ul.innerHTML = '';
        selectedClients.forEach((client, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <div>
                    <strong>${client.name}</strong><br>
                    Last Paid: $${client.last_payment_amount} on ${client.last_payment_date}<br>
                    Unpaid: $${client.unpaid_amount}, New: $${client.delivery_amount}<br>
                    <strong>Total: $${client.total_to_pay}</strong>
                </div>
                <button class="btn btn-sm btn-danger" onclick="removeClient(${index})">Remove</button>
            `;
            ul.appendChild(li);
        });

        document.getElementById('clients_data').value = JSON.stringify(selectedClients);
    }

    function removeClient(index) {
        selectedClients.splice(index, 1);
        renderClients();
    }
</script>
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">