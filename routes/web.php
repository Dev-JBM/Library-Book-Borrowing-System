<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;



Route::get('/', function () {
    // If user is already authenticated, send them to their landing page.
    if (auth()->check()) {
        $user = auth()->user();
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('books.search');
    }

    // Otherwise send to the login page.
    return redirect()->route('login');
});

// Authentication routes (simple)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Search Books route — using BookController
Route::get('/books/search', [BookController::class, 'search'])
    ->middleware(['auth'])
    ->name('books.search');

// Admin Panel routes
use App\Http\Middleware\IsAdmin;

Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/books', [AdminController::class, 'storeBook'])->name('books.store');
    Route::patch('/admin/borrowings/{id}/return', [AdminController::class, 'markAsReturned'])->name('admin.return');
});

// Borrow routes
use App\Http\Controllers\BorrowingController;

Route::middleware(['auth'])->group(function () {
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::patch('/borrowings/{id}/return', [BorrowingController::class, 'return'])->name('borrowings.return');
});

