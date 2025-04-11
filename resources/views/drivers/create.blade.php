@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Driver</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('drivers.store') }}" method="POST" id="driverForm">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter driver's name" required>
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter phone number" required>
                </div>

                <div class="form-group mb-3">
                    <label for="license_number">License Number</label>
                    <input type="text" name="license_number" class="form-control" placeholder="Enter license number" required>
                </div>

                <button type="submit" class="btn btn-success">Save Driver</button>
                <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
