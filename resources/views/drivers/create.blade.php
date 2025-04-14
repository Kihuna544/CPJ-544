@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Driver</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following errors:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('drivers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Driver Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label for="license_number" class="form-label">License Number</label>
            <input type="text" class="form-control" id="license_number" name="license_number" value="{{ old('license_number') }}">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
