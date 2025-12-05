<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function search(Request $request)
    {
        // Always define $search so compact() will not fail
        $search = $request->input('q');

        $query = Book::query();

        // If user typed something, filter the results
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
        }

        // Pagination
        $books = $query->paginate(10);

        // Return the view
        return view('books.search', compact('books', 'search'));
    }
}
