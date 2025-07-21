<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPendingUserController;

Route::get('/', function (Request $request) {
    $books = null;
    $categories = \App\Models\Category::all();

    // Only fetch books if there's a search query
    if ($request->filled('search') || $request->filled('category') || $request->filled('format')) {
        $query = \App\Models\Book::with('category')->where('status', 'Available');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }

        $books = $query->latest()->paginate(12);
    }

    return view('page.welcome', compact('books', 'categories'));
})->name('welcome');

Route::get('/contact', function () {
    return view('page.contact');
})->name('contact');

Route::get('/about', function () {
    return view('page.about');
})->name('about');

Route::get('/dashboard', function () {
    $stats = [
        'total_books' => \App\Models\Book::count(),
        'total_categories' => \App\Models\Category::count(),
        'total_borrowings' => \App\Models\Borrowing::where('status', 'Borrowed')->count(),
        'overdue_books' => \App\Models\Borrowing::where('status', 'Overdue')->count(),
    ];
    $recent_books = \App\Models\Book::latest()->take(5)->get();
    $recent_borrowings = \App\Models\Borrowing::with(['book', 'user'])->latest()->take(5)->get();
    return view('dashboard', compact('stats', 'recent_books', 'recent_borrowings'));
})->middleware(['auth', 'verified', 'prevent-back'])->name('dashboard');

Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Library System Routes
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/', [App\Http\Controllers\LibraryController::class, 'index'])->name('index');

        // Books
        Route::resource('books', App\Http\Controllers\BookController::class);

        // Categories
        Route::resource('categories', App\Http\Controllers\CategoryController::class);

        // Borrowings
        Route::resource('borrowings', App\Http\Controllers\BorrowingController::class);
        Route::patch('/borrowings/{borrowing}/return', [App\Http\Controllers\BorrowingController::class, 'return'])->name('borrowings.return');
        Route::patch('/borrowings/{borrowing}/lost', [App\Http\Controllers\BorrowingController::class, 'markAsLost'])->name('borrowings.lost');
    });

    // Libraries
    Route::resource('libraries', App\Http\Controllers\AdminLibraryController::class);

    // Users
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::post('users/{user}/logout-session', [App\Http\Controllers\UserController::class, 'logoutSession'])->name('users.logoutSession');
});

// Admin routes for pending user approval
Route::middleware(['auth', 'prevent-back'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('pending-users', [AdminPendingUserController::class, 'index'])->name('pending-users.index');
    Route::post('pending-users/{id}/approve', [AdminPendingUserController::class, 'approve'])->name('pending-users.approve');
    Route::post('pending-users/{id}/reject', [AdminPendingUserController::class, 'reject'])->name('pending-users.reject');
});

// Books Submit Page for External System
Route::get('/books/submit', [App\Http\Controllers\BookController::class, 'submitPage'])->name('books.submit.page');
Route::post('/books/submit-books', [App\Http\Controllers\BookController::class, 'submitBooks'])->name('books.submit.books');

require __DIR__.'/auth.php';
