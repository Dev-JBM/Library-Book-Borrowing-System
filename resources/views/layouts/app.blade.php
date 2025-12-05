<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Library Book Borrowing System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0f4c81;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .bg-primary {
            background-color: var(--primary) !important;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
