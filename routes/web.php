<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


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

// Placeholder routes for redirects after login
Route::get('/books/search', function () {
    return view('books.search');
})->middleware(['auth'])->name('books.search');

use App\Http\Middleware\IsAdmin;

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', IsAdmin::class])->name('admin.dashboard');
