@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white rounded-top-4 d-flex align-items-center">
                    <i class="fas fa-user-plus me-2"></i>
                    <h4 class="mb-0">Add New Client</h4>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-building me-1"></i> Business Name</label>
                            <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" placeholder="e.g. Mama Grace Rice Traders">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-phone me-1"></i> Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. +256700000000">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-camera me-1"></i> Profile Photo</label>
                            <div class="d-flex flex-column gap-2">
                                <input type="file" name="profile_photo" accept="image/*" capture="user" class="form-control" title="Capture or select a client photo">
                                <small class="text-muted">You can take a photo using your camera or upload one from your device.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-plus-circle me-1"></i> Add Client
                            </button>
                            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
