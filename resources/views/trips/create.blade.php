<!-- In trips/create.blade.php -->
<form action="{{ route('trips.store') }}" method="POST">
    @csrf
    <label for="client">Select Client</label>
    <select id="client" name="client_id" onchange="getPaymentDetails(this.value)">
        @foreach($clients as $client)
            <option value="{{ $client->id }}">{{ $client->name }}</option>
        @endforeach
    </select>

    <div id="payment-details">
        <!-- Payment details will be displayed here via JavaScript -->
    </div>

    <label for="delivery_amount">Delivery Amount</label>
    <input type="number" name="delivery_amount" id="delivery_amount" required>

    <button type="submit">Submit</button>
</form>

<script>
    function getPaymentDetails(clientId) {
        if(clientId) {
            fetch(`/clients/${clientId}/payment-status`)
                .then(response => response.json())
                .then(data => {
                    let detailsDiv = document.getElementById('payment-details');
                    if (data.paid) {
                        detailsDiv.innerHTML = `<p>Last Payment: $${data.last_payment_amount} on ${data.last_payment_date}</p>`;
                        detailsDiv.innerHTML += `<p>Total to Pay for New Delivery: $${data.new_delivery_amount}</p>`;
                    } else {
                        detailsDiv.innerHTML = `<p>Last Payment: $${data.last_payment_amount} on ${data.last_payment_date}</p>`;
                        detailsDiv.innerHTML += `<p>Unpaid Amount: $${data.unpaid_amount}</p>`;
                        detailsDiv.innerHTML += `<p>Total to Pay for New Delivery: $${data.unpaid_amount + data.new_delivery_amount}</p>`;
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>
