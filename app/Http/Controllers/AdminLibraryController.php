<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminLibraryController extends Controller
{
    /**
     * Display a listing of libraries.
     */
    public function index(): View
    {
        $libraries = Library::all();
        return view('library.libraries.index', compact('libraries'));
    }

    /**
     * Show the form for creating a new library.
     */
    public function create(): View
    {
        return view('library.libraries.create');
    }

    /**
     * Store a newly created library.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:libraries',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);
        Library::create($validated);
        return redirect()->route('libraries.index')->with('success', 'Library created successfully!');
    }

    /**
     * Show the form for editing the specified library.
     */
    public function edit(Library $library): View
    {
        return view('library.libraries.edit', compact('library'));
    }

    /**
     * Update the specified library.
     */
    public function update(Request $request, Library $library): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:libraries,name,' . $library->id,
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);
        $library->update($validated);
        return redirect()->route('libraries.index')->with('success', 'Library updated successfully!');
    }

    /**
     * Remove the specified library.
     */
    public function destroy(Library $library): RedirectResponse
    {
        $library->delete();
        return redirect()->route('libraries.index')->with('success', 'Library deleted successfully!');
    }
}
