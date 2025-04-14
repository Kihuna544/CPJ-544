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

