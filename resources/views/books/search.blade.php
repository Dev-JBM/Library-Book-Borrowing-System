@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <style>
        :root { --primary: #0f4c81; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .bg-primary { background-color: var(--primary) !important; }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Search Books</h3>
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button class="btn btn-outline-primary">Logout</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(!empty($hasOverdue) && $hasOverdue)
        <div class="alert alert-warning">
            You have overdue books. Please return them before borrowing more.
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('books.search') }}" method="GET" class="d-flex">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by title, author, or ISBN" class="form-control me-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    @if(isset($books) && $books->count())
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered mb-0">
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
                                        @if($book->stock <= 0 || (!empty($hasOverdue) && $hasOverdue)) disabled @endif
                                        title="{{ ($book->stock <= 0) ? 'Out of stock' : ((!empty($hasOverdue) && $hasOverdue) ? 'You have overdue books' : 'Reserve this book') }}"
                                    >
                                        Reserve
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $books->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-warning">No books found.</div>
    @endif
</div>
@endsection