<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\SubmittedBook;
use Illuminate\Support\Carbon;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index(Request $request): View
    {
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

        $books = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('library.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('library.books.create', compact('categories'));
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'edition' => 'nullable|string|max:50',
            'genre' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255',
            'call_number' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'language' => 'required|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'format' => 'required|in:Hardcover,Paperback,E-book,Audiobook',
            'status' => 'required|in:Available,Maintenance,Lost,Reserved',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Book::create($validated);

        return redirect()->route('library.index')
            ->with('success', 'Book added successfully!');
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        $book->load(['category', 'borrowings.user']);
        return view('library.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book): View
    {
        $categories = Category::all();
        return view('library.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'edition' => 'nullable|string|max:50',
            'genre' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255',
            'call_number' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'language' => 'required|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'format' => 'required|in:Hardcover,Paperback,E-book,Audiobook',
            'status' => 'required|in:Available,Maintenance,Lost,Reserved',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $book->update($validated);

        return redirect()->route('library.index')
            ->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('library.index')
            ->with('success', 'Book deleted successfully!');
    }

    /**
     * Handle AJAX submission of books to external system and save to submitted_books.
     */
    public function submitBooks(Request $request)
    {
        $books = $request->input('books', []);
        $now = Carbon::now();
        foreach ($books as $book) {
            SubmittedBook::create([
                'book_id' => $book['id'],
                'title' => $book['title'],
                'author' => $book['author'] ?? null,
                'isbn' => $book['isbn'] ?? null,
                'submitted_at' => $now,
            ]);
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Display all books in a view for submitting to an external system, with pagination and search, and show submitted books tab.
     */
    public function submitPage(Request $request): View
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $query = Book::with('category');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhere('isbn', 'like', "%$search%")
                  ->orWhere('publisher', 'like', "%$search%")
                  ->orWhere('genre', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('call_number', 'like', "%$search%")
                  ->orWhere('location', 'like', "%$search%")
                  ->orWhere('format', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%")
                  ;
            });
        }
        $books = $query->paginate($perPage)->appends($request->all());
        $submittedBooks = SubmittedBook::orderByDesc('submitted_at')->paginate(10, ['*'], 'submitted_page');
        return view('library.books.submit', compact('books', 'submittedBooks'));
    }
}
