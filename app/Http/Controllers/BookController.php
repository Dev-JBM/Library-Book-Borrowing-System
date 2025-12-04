<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // Search method
    public function search(Request $request)
    {
        $query = Book::query();

        // If search input exists, filter by title, author, or ISBN
        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
        }

        // Get results with pagination (10 per page)
        $books = $query->paginate(10);

        // Return the view with books and search term
        return view('books.search', compact('books', 'search'));
    }
}
