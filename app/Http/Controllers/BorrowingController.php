<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BorrowingController extends Controller
{
    /**
     * Display a listing of borrowings.
     */
    public function index(Request $request): View
    {
        $query = Borrowing::with(['book', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        $borrowings = $query->latest()->paginate(15);
        $users = User::all();

        return view('library.borrowings.index', compact('borrowings', 'users'));
    }

    /**
     * Show the form for creating a new borrowing.
     */
    public function create(): View
    {
        $books = Book::where('available_copies', '>', 0)->get();
        $users = User::all();
        return view('library.borrowings.create', compact('books', 'users'));
    }

    /**
     * Store a newly created borrowing.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->available_copies <= 0) {
            return back()->withErrors(['book_id' => 'This book is not available for borrowing.']);
        }

        $validated['borrowed_at'] = now();
        $validated['status'] = 'Borrowed';

        Borrowing::create($validated);

        // Update book availability
        $book->decrement('available_copies');

        return redirect()->route('library.borrowings.index')
            ->with('success', 'Book borrowed successfully!');
    }

    /**
     * Return a borrowed book.
     */
    public function return(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'Borrowed') {
            return back()->withErrors(['status' => 'This book has already been returned.']);
        }

        $borrowing->update([
            'returned_at' => now(),
            'status' => 'Returned',
        ]);

        // Update book availability
        $borrowing->book->increment('available_copies');

        return redirect()->route('library.borrowings.index')
            ->with('success', 'Book returned successfully!');
    }

    /**
     * Mark a book as lost.
     */
    public function markAsLost(Borrowing $borrowing): RedirectResponse
    {
        $borrowing->update([
            'status' => 'Lost',
        ]);

        return redirect()->route('library.borrowings.index')
            ->with('success', 'Book marked as lost!');
    }

    /**
     * Show the form for editing the specified borrowing.
     */
    public function edit(Borrowing $borrowing): View
    {
        $books = Book::all();
        $users = User::all();
        return view('library.borrowings.edit', compact('borrowing', 'books', 'users'));
    }

    /**
     * Update the specified borrowing.
     */
    public function update(Request $request, Borrowing $borrowing): RedirectResponse
    {
        $validated = $request->validate([
            'due_date' => 'required|date',
            'status' => 'required|in:Borrowed,Returned,Overdue,Lost',
            'notes' => 'nullable|string',
        ]);

        $borrowing->update($validated);

        return redirect()->route('library.borrowings.index')
            ->with('success', 'Borrowing updated successfully!');
    }
}
