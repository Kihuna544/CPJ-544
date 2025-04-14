{{-- drivers/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Drivers</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createDriverModal">
        <i class="fas fa-user-plus me-1"></i> Add Driver
    </button>

    @include('drivers.create')

    <div class="row">
        @foreach($drivers as $driver)
        <div class="col-md-4 mb-4">
            <div class="card glass-card">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-3x text-primary mb-2"></i>
                    <h5 class="card-title">{{ $driver->name }}</h5>
                    <p class="card-text">📞 {{ $driver->phone }}<br>🪪 {{ $driver->license_number }}</p>
                    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

