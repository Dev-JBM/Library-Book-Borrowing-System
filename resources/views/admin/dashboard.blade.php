<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #0F3D73;
            --sky: #5AB9FF;
            --glass: rgba(255, 255, 255, 0.22);
            --glass-border: rgba(255, 255, 255, 0.45);
        }

        /* Background */
        body {
            background: linear-gradient(135deg, var(--navy), var(--sky));
            font-family: "Poppins", sans-serif;
            color: #fff;
            min-height: 100vh;
        }

        /* Glass container */
        .glass-wrapper {
            background: var(--glass);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.18);
            animation: fadeIn 0.7s ease-out;
        }

        /* Floating animation */
        .floating {
            animation: float 3.8s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }

        /* Fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0px); }
        }

        /* Buttons */
        .btn-primary {
            background: var(--navy);
            border-color: var(--navy);
            border-radius: 12px;
            padding: 10px 20px;
            transition: 0.3s ease;
            box-shadow:
                3px 3px 8px rgba(0, 0, 0, 0.2),
                -3px -3px 8px rgba(255, 255, 255, 0.5);
        }

        .btn-primary:hover {
            background: #0C3260;
            transform: translateY(-3px);
            box-shadow:
                6px 6px 14px rgba(0, 0, 0, 0.3),
                -4px -4px 14px rgba(255, 255, 255, 0.6);
        }

        .btn-outline-danger {
            border-radius: 12px;
        }

        /* Stats cards */
        .stats-card {
            border-radius: 18px;
            padding: 25px;
            color: white;
            font-weight: 600;
            box-shadow:
                3px 3px 10px rgba(0, 0, 0, 0.18),
                -3px -3px 10px rgba(255, 255, 255, 0.3);
        }

        /* Table */
        table thead th {
            background: rgba(255, 255, 255, 0.45) !important;
            color: #000;
        }

        table tbody td {
            color: #000;
        }

        table tbody tr:hover {
            background: rgba(255, 255, 255, 0.35) !important;
            transform: scale(1.01);
            backdrop-filter: blur(3px);
        }
    </style>
</head>

<body>

<div class="container mt-5 floating">
    <div class="glass-wrapper">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Admin Dashboard</h3>

            <div>
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addBookModal">
                    + Add Book
                </button>

                <form method="POST" action="{{ url('/logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-danger">Logout</button>
                </form>
            </div>
        </div>

        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Stats cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stats-card bg-primary">
                    <h5>Total Books</h5>
                    <h2>{{ $totalBooks }}</h2>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stats-card bg-success">
                    <h5>Active Loans</h5>
                    <h2>{{ $activeLoansCount }}</h2>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stats-card bg-warning text-dark">
                    <h5>Registered Users</h5>
                    <h2>{{ $usersCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Active Borrowings Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="text-secondary mb-0">Borrowed Books</h5>
            </div>

            <div class="card-body">
                @if($activeBorrowings->isEmpty())
                    <p class="text-center text-muted">No books currently borrowed.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Book</th>
                                    <th>Borrowed</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($activeBorrowings as $borrowing)
                                <tr>
                                    <td>{{ $borrowing->user->name }}</td>
                                    <td>{{ $borrowing->book->title }}</td>
                                    <td>{{ $borrowing->borrowed_at->format('M d, Y') }}</td>
                                    <td class="{{ $borrowing->due_date?->isPast() ? 'text-danger fw-bold' : '' }}">
                                        {{ $borrowing->due_date ? $borrowing->due_date->format('M d, Y') : '—' }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.return', $borrowing->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-success">Mark Returned</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Add Book Modal -->
<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-modal floating">

            <div class="modal-header border-0">
                <h5 class="modal-title text-dark fw-semibold">Add New Book</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('books.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <label class="form-label text-dark fw-medium">Title</label>
                    <input name="title" class="form-control glass-input mb-3" required>

                    <label class="form-label text-dark fw-medium">Author</label>
                    <input name="author" class="form-control glass-input mb-3" required>

                    <label class="form-label text-dark fw-medium">ISBN</label>
                    <input name="isbn" class="form-control glass-input mb-3" required>

                    <label class="form-label text-dark fw-medium">Stock</label>
                    <input name="stock" type="number" class="form-control glass-input" min="1" value="1" required>
                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary rounded-3">Save Book</button>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    /* Glass effect modal */
    .glass-modal {
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.45);
        padding: 5px 10px;
        box-shadow:
            0 12px 32px rgba(0, 0, 0, 0.25),
            inset 0 0 20px rgba(255, 255, 255, 0.25);
        animation: fadeInScale 0.4s ease-out;
    }

    /* Smooth pop animation */
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Floating subtle animation */
    .floating {
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    /* Inputs inside modal */
    .glass-input {
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        padding: 10px 12px;
        backdrop-filter: blur(5px);
        transition: 0.3s ease;
    }

    .glass-input:focus {
        border-color: #0F3D73;
        box-shadow: 0 0 6px rgba(15, 61, 115, 0.4);
        background: rgba(255, 255, 255, 0.85);
        transform: scale(1.02);
    }

    .modal-title {
        font-size: 1.25rem;
        letter-spacing: 0.5px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
