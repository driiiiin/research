<?php

namespace App\Http\Controllers;

use App\Models\HealthResearch;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\SubmittedHealthResearch;
use Illuminate\Support\Carbon;

class HealthResearchController extends Controller
{
    /**
     * Display a listing of health researches.
     */
    public function index(Request $request): View
    {
        $query = HealthResearch::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $healthResearches = $query->latest()->paginate(15);

        return view('research.index', compact('healthResearches'));
    }

    /**
     * Show the form for creating a new health research.
     */
    public function create(): View
    {
        return view('research.health_researches.create');
    }

    /**
     * Store a newly created health research.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:health_researches',
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
        ]);

        // Always auto-generate accession number server-side with retry on collision
        $attempts = 0;
        $created = false;
        while (!$created && $attempts < 5) {
            $attempts++;
            $validated['accession_no'] = $this->generateNextAccessionNo();
            try {
                HealthResearch::create($validated);
                $created = true;
            } catch (\Illuminate\Database\QueryException $e) {
                if (strpos($e->getMessage(), 'accession_no') === false) {
                    throw $e;
                }
            }
        }
        if (!$created) {
            return back()->withErrors(['accession_no' => 'Failed to generate a unique accession number. Please try again.']);
        }

        return redirect()->route('research.index')
            ->with('success', 'Health research added successfully!');
    }

    /**
     * Return the next accession number for AJAX consumers.
     */
    public function nextAccession(Request $request)
    {
        return response()->json([
            'next' => $this->generateNextAccessionNo(),
        ]);
    }

    /**
     * Generate the next accession number in the format D0001HXXXXXX.
     * Increments the numeric tail, starting from D0001H000001.
     */
    private function generateNextAccessionNo(): string
    {
        $prefix = 'D0001H';
        $latest = HealthResearch::whereNotNull('accession_no')
            ->where('accession_no', 'like', $prefix.'%')
            ->orderByDesc('accession_no')
            ->value('accession_no');

        if (!$latest) {
            return $prefix . '000001';
        }

        $number = (int) substr($latest, strlen($prefix));
        $next = $number + 1;
        return $prefix . str_pad((string) $next, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Display the specified health research.
     */
    public function show(HealthResearch $healthResearch): View
    {
        return view('research.health_researches.show', compact('healthResearch'));
    }

    /**
     * Show the form for editing the specified health research.
     */
    public function edit(HealthResearch $healthResearch): View
    {
        return view('research.health_researches.edit', compact('healthResearch'));
    }

    /**
     * Update the specified health research.
     */
    public function update(Request $request, HealthResearch $healthResearch): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:health_researches,isbn,' . $healthResearch->id,
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
        ]);

        $healthResearch->update($validated);

        return redirect()->route('research.index')
            ->with('success', 'Health research updated successfully!');
    }

    /**
     * Remove the specified health research.
     */
    public function destroy(HealthResearch $healthResearch): RedirectResponse
    {
        $healthResearch->delete();

        return redirect()->route('research.index')
            ->with('success', 'Health research deleted successfully!');
    }

    /**
     * Handle AJAX submission of health researches to external system and save to submitted_health_researches.
     */
    public function submitHealthResearches(Request $request)
    {
        $healthResearches = $request->input('health_researches', []);
        $now = Carbon::now();
        foreach ($healthResearches as $healthResearch) {
            SubmittedHealthResearch::create([
                'health_research_id' => $healthResearch['id'],
                'title' => $healthResearch['title'],
                'author' => $healthResearch['author'] ?? null,
                'isbn' => $healthResearch['isbn'] ?? null,
                'submitted_at' => $now,
            ]);
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Display all health researches in a view for submitting to an external system, with pagination and search, and show submitted health researches tab.
     */
    public function submitPage(Request $request): View
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $query = HealthResearch::query();
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
        $healthResearches = $query->paginate($perPage)->appends($request->all());
        $submittedHealthResearches = SubmittedHealthResearch::orderByDesc('submitted_at')->paginate(10, ['*'], 'submitted_page');
        return view('research.health_researches.submit', compact('healthResearches', 'submittedHealthResearches'));
    }
}
