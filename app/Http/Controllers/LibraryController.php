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
    public function index(Request $request): View
    {
        $stats = [
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'total_borrowings' => Borrowing::where('status', 'Borrowed')->count(),
            'overdue_books' => Borrowing::where('status', 'Overdue')->count(),
        ];

        $recent_books = Book::latest()->take(5)->get();
        $recent_borrowings = Borrowing::with(['book', 'user'])->latest()->take(5)->get();

        // Get books with search and filter functionality
        $query = Book::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $books = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('library.index', compact('stats', 'recent_books', 'recent_borrowings', 'books', 'categories'));
    }
}
