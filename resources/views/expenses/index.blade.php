@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">All Expenses</h2>
        <a href="{{ route('expenses.create') }}" class="btn btn-success">Add New Expense</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover shadow">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Trip</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->expense_date }}</td>
                    <td>{{ $expense->trip->destination ?? 'N/A' }}</td>
                    <td>{{ ucfirst($expense->expense_type) }}</td>
                    <td>{{ number_format($expense->amount, 2) }}</td>
                    <td>{{ $expense->notes }}</td>
                    <td>
                        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $expenses->links() }}
    </div>

    <div class="card mt-4 bg-light shadow-sm">
        <div class="card-body">
            <h5>Total Expenses: <span class="text-danger fw-bold">{{ number_format($totalExpenses, 2) }} UGX</span></h5>
        </div>
    </div>
</div>
@endsection
