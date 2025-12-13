@extends('layouts.app')

@section('content')

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --navy: #0F3D73;
        --sky: #5AB9FF;
        --glass: rgba(255, 255, 255, 0.25);
        --glass-border: rgba(255, 255, 255, 0.35);
    }

    body {
        background: linear-gradient(135deg, var(--navy), var(--sky));
        font-family: 'Inter', sans-serif;
    }

    /* Headings use Poppins */
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
    }

    /* Container glass card */
    .glass-wrapper {
        background: var(--glass);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        animation: fadeIn 0.8s ease-out;
    }

    /* Fade animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Floating subtle animation */
    .floating {
        animation: float 3.8s ease-in-out infinite;
    }
    @keyframes float {
        0% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
        100% { transform: translateY(0); }
    }

    /* Search bar */
    .search-bar {
        background: rgba(255, 255, 255, 0.35);
        border-radius: 15px;
        border: 1px solid var(--glass-border);
        padding: 12px 18px;
        font-size: 1rem;
        box-shadow:
            4px 4px 10px rgba(0, 0, 0, 0.12),
            -4px -4px 10px rgba(255, 255, 255, 0.55);
        transition: 0.3s ease;
    }

    .search-bar:focus {
        transform: scale(1.03);
        box-shadow:
            5px 5px 12px rgba(0, 0, 0, 0.18),
            -5px -5px 12px rgba(255, 255, 255, 0.65);
    }

    /* Buttons */
    .btn-primary {
        background: var(--navy);
        border-color: var(--navy);
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 500;
        transition: 0.3s ease;
        box-shadow:
            3px 3px 8px rgba(0, 0, 0, 0.18),
            -3px -3px 8px rgba(255, 255, 255, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        background: #0C3260;
        box-shadow:
            5px 5px 14px rgba(0, 0, 0, 0.25),
            -5px -5px 14px rgba(255, 255, 255, 0.6);
    }

    .btn-outline-primary {
        border-color: #fff;
        color: #fff;
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 500;
    }

    .btn-outline-primary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: #fff;
        color: #fff;
    }

    /* Table styling */
    table {
        border-radius: 12px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(6px);
    }

    table thead th,
    table tbody td {
        color: #000 !important;
        font-family: 'Inter', sans-serif;
    }

    table tbody tr {
        transition: 0.25s ease;
    }

    table tbody tr:hover {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(4px);
        transform: scale(1.01);
    }

    h3, label, p {
        color: #fff !important;
    }
</style>

<div class="container mt-4 floating">
    <div class="glass-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-semibold">Search Books</h3>

            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button class="btn btn-outline-primary">Logout</button>
            </form>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!empty($hasOverdue) && $hasOverdue)
            <div class="alert alert-warning">
                You have overdue books. Please return them before borrowing more.
            </div>
        @endif

        {{-- Search bar --}}
        <div class="mb-4">
            <form action="{{ route('books.search') }}" method="GET" class="d-flex">
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Search by title, author, or ISBN"
                       class="form-control search-bar me-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        {{-- Results --}}
        @if(isset($books) && $books->count())
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->stock }}</td>

                        <td>
                            <form method="POST" action="{{ route('borrowings.store') }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-sm"
                                    @if($book->stock <= 0 || (!empty($hasOverdue) && $hasOverdue))
                                        disabled
                                    @endif>
                                    Reserve
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $books->links() }}

        @else
            <div class="alert alert-light text-center text-dark fw-semibold">
                No books found.
            </div>
        @endif
    </div>
</div>

@endsection
