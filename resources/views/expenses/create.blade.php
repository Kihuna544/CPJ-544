@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Add New Expense</h2>

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="trip_id" class="form-label">Trip</label>
            <select name="trip_id" class="form-control" required>
                <option value="">-- Select Trip --</option>
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}">{{ $trip->destination }} - {{ $trip->trip_date }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="expense_type" class="form-label">Expense Type</label>
            <input type="text" name="expense_type" class="form-control" placeholder="e.g. Fuel, Repairs" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount (UGX)</label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="expense_date" class="form-label">Date</label>
            <input type="date" name="expense_date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Expense</button>
    </form>
</div>
@endsection
