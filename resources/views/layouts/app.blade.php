{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>CPJ Transport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            transition: background-color 0.4s, color 0.4s;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 2rem;
        }

        .dark-toggle {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light text-dark">
    <div class="container py-4">
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <h2>🚛 CPJ Transport</h2>
            <i class="fas fa-moon dark-toggle fs-4" onclick="toggleDarkMode()" title="Toggle Dark Mode"></i>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.getAttribute("data-bs-theme") === "dark";
            html.setAttribute("data-bs-theme", isDark ? "light" : "dark");
        }
    </script>
</body>
</html>


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


{{-- drivers/create.blade.php --}}
<div class="modal fade" id="createDriverModal" tabindex="-1" aria-labelledby="createDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content glass-card">
            <div class="modal-header">
                <h5 class="modal-title" id="createDriverModalLabel">
                    <i class="fas fa-id-card-alt me-2"></i> Add New Driver
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('drivers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle fa-4x text-primary"></i>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="license_number" class="form-label">License Number</label>
                        <input type="text" name="license_number" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-check-circle me-1"></i> Save Driver
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
