<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = auth()->user();
        $book = Book::findOrFail($request->book_id);

        // Prevent borrowing if the user has any overdue active borrowings
        $hasOverdue = Borrowing::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->where('due_date', '<', now())
            ->exists();

        if ($hasOverdue) {
            return back()->withErrors(['borrow' => 'You have overdue books. Return them before borrowing new ones.']);
        }

        // Check availability
        if ($book->stock <= 0) {
            return back()->withErrors(['borrow' => 'This book is currently out of stock.']);
        }

        // Record the loan
        $borrowing = Borrowing::create([
            'user_id'     => $user->id,
            'book_id'     => $book->id,
            'borrowed_at' => now(),
            'due_date'    => now()->addDays(14),
            'returned_at' => null,
        ]);

        // Decrement stock
        $book->decrement('stock');

        return back()->with('success', 'Book reserved successfully. Due in 14 days.');
    }

    public function return(Request $request, int $id)
    {
        $user = auth()->user();

        // Find the borrowing owned by the user and not yet returned
        $borrowing = Borrowing::where('id', $id)
            ->where('user_id', $user->id)
            ->whereNull('returned_at')
            ->firstOrFail();

        // Update status
        $borrowing->update([
            'returned_at' => now(),
        ]);

        // Increment stock
        $borrowing->book->increment('stock');

        return back()->with('success', 'Book returned successfully.');
    }
}