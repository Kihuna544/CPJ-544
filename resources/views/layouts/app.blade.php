<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPJ544 Transport Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <style>
        /* Custom sidebar styles */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #2f4f4f;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
            font-size: 18px;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="p-3">
            <h3 class="text-white">CPJ544 Transport</h3>
        </div>
        <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('trips.index') }}"><i class="fas fa-road"></i> Trips</a>
        <a href="{{ route('clients.index') }}"><i class="fas fa-users"></i> Clients</a>
        <a href="{{ route('drivers.index') }}"><i class="fas fa-id-badge"></i> Drivers</a>
        <a href="{{ route('payments.index') }}"><i class="fas fa-credit-card"></i> Payments</a>
        <a href="{{ route('expenses.index') }}"><i class="fas fa-dollar-sign"></i> Expenses</a>
        <a href="{{ route('journeys.index') }}"><i class="fas fa-map"></i> Journeys</a>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
