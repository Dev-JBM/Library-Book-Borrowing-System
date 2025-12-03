<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
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
        .text-primary {
            color: var(--primary) !important;
        }
    </style>
</head>
<body class="bg-light">
    <!-- ADDED COMMENTS FOR EASE OF VIEWING :3 -->
    <div class="container mt-4">
        
        <!-- 1. HEADER & ACTIONS -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary fw-bold">Library Admin Panel</h3>
            <div>
                <!-- Button to trigger Add Book modal -->
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addBookModal">
                    + Add New Book
                </button>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ url('/logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-danger">Logout</button>
                </form>
            </div>
        </div>

        <!-- 2. SUCCESS MESSAGES -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 3. STATISTICS CARDS -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Books</h5>
                        <p class="card-text display-6 fw-bold">{{ $totalBooks }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Active Loans</h5>
                        <p class="card-text display-6 fw-bold">{{ $activeLoansCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-dark">Registered Users</h5>
                        <p class="card-text display-6 fw-bold text-dark">{{ $usersCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. ACTIVE BORROWINGS TABLE -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-secondary">Current Borrowed Books</h5>
            </div>
            <div class="card-body">
                @if($activeBorrowings->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <p class="mb-0">No books are currently borrowed.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User Name</th>
                                    <th>Book Title</th>
                                    <th>Borrowed Date</th>
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
                                    <td>
                                        @if($borrowing->due_date)
                                            <span class="{{ $borrowing->due_date->isPast() ? 'text-danger fw-bold' : '' }}">
                                                {{ $borrowing->due_date->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">No Due Date</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.return', $borrowing->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                Mark Returned
                                            </button>
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

    <!-- 5. ADD BOOK MODAL -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" name="author" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" name="stock" class="form-control" value="1" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>