<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    /**
     * Display the library dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'total_borrowings' => Borrowing::where('status', 'Borrowed')->count(),
            'overdue_books' => Borrowing::where('status', 'Overdue')->count(),
        ];

        $recent_books = Book::latest()->take(5)->get();
        $recent_borrowings = Borrowing::with(['book', 'user'])->latest()->take(5)->get();

        return view('library.index', compact('stats', 'recent_books', 'recent_borrowings'));
    }
}
