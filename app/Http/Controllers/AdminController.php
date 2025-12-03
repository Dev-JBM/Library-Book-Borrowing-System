<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all active borrowings (returned_at = null) (read migration table for explanation why)
        $activeBorrowings = \App\Models\Borrowing::with(['user', 'book'])
                        ->whereNull('returned_at')
                        ->get();

        $totalBooks = \App\Models\Book::count();
        $usersCount = \App\Models\User::where('role', 'user')->count();
        $activeLoansCount = $activeBorrowings->count();

        return view('admin.dashboard', compact('activeBorrowings', 'totalBooks', 'usersCount', 'activeLoansCount'));
    }

    public function markAsReturned($id)
    {
        $borrowing = \App\Models\Borrowing::findOrFail($id);
        
        // Mark as returned
        $borrowing->update([
            'returned_at' => now(),
        ]);

        // Increase the book stock again
        $borrowing->book->increment('stock');

        return redirect()->back()->with('success', 'Book marked as returned successfully!');
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required|unique:books',
            'stock' => 'required|integer|min:1'
        ]);

        \App\Models\Book::create($request->all());

        return redirect()->back()->with('success', 'Book added successfully!');
    }
}