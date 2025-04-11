@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add Driver</h1>

    <form action="{{ route('drivers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>License Number:</label>
            <input type="text" name="license_number" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
