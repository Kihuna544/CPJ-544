@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row text-center">
        <h2 class="mb-4">📊 CPJ544 Financial Dashboard</h2>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-lg">
                <div class="card-body">
                    <h4>Total Income</h4>
                    <h3>₦{{ number_format($totalIncome, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card bg-danger text-white shadow-lg">
                <div class="card-body">
                    <h4>Total Expenses</h4>
                    <h3>₦{{ number_format($totalExpenses, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card bg-primary text-white shadow-lg">
                <div class="card-body">
                    <h4>Profit</h4>
                    <h3>₦{{ number_format($profit, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
