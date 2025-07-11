<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataEncodingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
})->middleware(['auth', 'verified', 'prevent-back'])->name('dashboard');

Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Data Encoding Routes
    Route::get('/data-encoding', [DataEncodingController::class, 'index'])->name('data-encoding');
    Route::post('/data-encoding/encode', [DataEncodingController::class, 'store'])->name('data-encoding.encode');
    Route::post('/data-encoding/decode', [DataEncodingController::class, 'decode'])->name('data-encoding.decode');

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
});

require __DIR__.'/auth.php';
