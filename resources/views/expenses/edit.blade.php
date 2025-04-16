@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Expense</h2>

    <form action="{{ route('expenses.update', $expense) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label for="trip_id" class="form-label">Trip</label>
            <select name="trip_id" class="form-control" required>
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}" {{ $expense->trip_id == $trip->id ? 'selected' : '' }}>
                        {{ $trip->destination }} - {{ $trip->trip_date }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="expense_type" class="form-label">Expense Type</label>
            <input type="text" name="expense_type" class="form-control" value="{{ $expense->expense_type }}" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount (UGX)</label>
            <input type="number" name="amount" step="0.01" class="form-control" value="{{ $expense->amount }}" required>
        </div>

        <div class="mb-3">
            <label for="expense_date" class="form-label">Date</label>
            <input type="date" name="expense_date" class="form-control" value="{{ $expense->expense_date }}" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" class="form-control">{{ $expense->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Expense</button>
    </form>
</div>
@endsection
