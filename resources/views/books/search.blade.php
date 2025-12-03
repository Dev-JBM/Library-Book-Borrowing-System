<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Search</title>
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Book Search (Placeholder)</h3>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button class="btn btn-outline-primary">Logout</button>
            </form>
        </div>

        <div class="card">
            <div class="card-body">
                <p>This is a placeholder page for the regular user landing area. The search UI will be implemented here later.</p>

                <div class="alert alert-secondary">Use the navigation to find books, borrow items, and view your account.</div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>