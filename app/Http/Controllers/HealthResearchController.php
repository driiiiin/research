<?php

namespace App\Http\Controllers;

use App\Models\HealthResearch;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\SubmittedHealthResearch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class HealthResearchController extends Controller
{
    /**
     * Display a listing of health researches.
     */
    public function index(Request $request): View|string
    {
        $query = HealthResearch::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('research_title', 'like', "%{$search}%")
                  ->orWhere('accession_no', 'like', "%{$search}%")
                  ->orWhere('doi', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhere('mesh_keywords', 'like', "%{$search}%")
                  ->orWhere('non_mesh_keywords', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $healthResearches = $query->with('authors')->latest()->paginate(15);

        if ($request->ajax()) {
            return view('research.partials.table_body', compact('healthResearches'))->render();
        }

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
        Log::info('HealthResearchController@store called', ['request' => $request->all()]);
        $validated = $request->validate([
            'accession_no' => 'nullable|string|max:20|unique:health_researches',
            'research_title' => 'required|string|max:500',
            'subtitle' => 'nullable|string|max:500',
            'date_issued_from_month' => 'nullable|integer|min:1|max:12',
            'date_issued_from_year' => 'required|integer|min:1900|max:2100',
            'date_issued_to_month' => 'nullable|integer|min:1|max:12',
            'date_issued_to_year' => 'nullable|integer|min:1900|max:2100',
            'volume_no' => 'nullable|string|max:50',
            'issue_no' => 'nullable|string|max:50',
            'pages' => 'nullable|string|max:50',
            'article_no' => 'nullable|string|max:50',
            'doi' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'research_category' => 'required|in:Institutional,Collaborative,Commissioned',
            'research_type' => 'required|in:Basic,Applied,Experimental',
            'abstract_type' => 'nullable|string|max:100',
            'research_abstract' => 'nullable|string',
            'reference' => 'nullable|string',
            'mesh_keywords' => 'nullable|string',
            'non_mesh_keywords' => 'nullable|string',
            // Focus areas come in as checkbox arrays
            'sdg_addressed' => 'required|array|min:1',
            'sdg_addressed.*' => 'nullable|string',
            'nuhra_addressed' => 'required|array|min:1',
            'nuhra_addressed.*' => 'nullable|string',
            'nuhra_others' => 'nullable|string|max:255',
            'mthria_addressed' => 'required|array|min:1',
            'mthria_addressed.*' => 'nullable|string',
            'mthria_others' => 'nullable|string|max:255',
            'agenda_addressed' => 'nullable|array',
            'agenda_addressed.*' => 'nullable|string',
            'implementing_agency' => 'nullable|string|max:255',
            'cooperating_agency' => 'nullable|string|max:255',
            'funding_agency' => 'nullable|string|max:255',
            'is_gov_fund' => 'nullable|in:yes,no',
            'budget' => 'nullable|numeric|min:0',
            'currency_code' => 'nullable|string|max:10',
            // removed: general_note, fund_information, duration, start_date,
            // end_date, year_end_date, keywords, policy_brief, final_report
            'status' => 'nullable|string|max:100',
            // removed: citation, upload_status, remarks
            // Author fields
            'author_last_name' => 'nullable|array',
            'author_last_name.*' => 'nullable|string|max:100',
            'author_first_name' => 'nullable|array',
            'author_first_name.*' => 'nullable|string|max:100',
            'author_middle_name' => 'nullable|array',
            'author_middle_name.*' => 'nullable|string|max:100',
            'author_suffix' => 'nullable|array',
            'author_suffix.*' => 'nullable|string|max:20',
            // Location fields
            'format' => 'required|array|min:1',
            'format.*' => 'required|string|in:Print,Non-Print',
            'physical_location' => 'nullable|array',
            'physical_location.*' => 'nullable|string|max:255',
            'location_number' => 'nullable|array',
            'location_number.*' => 'nullable|string|max:50',
            'text_availability' => 'nullable|array',
            'text_availability.*' => 'nullable|string|in:Abstract Only,Full-text',
            'mode_of_access' => 'nullable|array',
            'mode_of_access.*' => 'nullable|string|max:100',
            'institutional_email' => 'nullable|array',
            'institutional_email.*' => 'nullable|email|max:255',
            'enter_url' => 'nullable|array',
            'enter_url.*' => 'nullable|boolean',
            'url' => 'nullable|array',
            'url.*' => 'nullable|url|max:255',
            'upload_file' => 'nullable|array',
            'upload_file.*' => 'nullable|boolean',
            'file' => 'nullable|array',
            'file.*' => 'nullable|file|max:10240', // 10MB max
        ]);
        Log::info('Validation passed', ['validated' => $validated]);

        // Conditional date rules depending on mode
        $dateMode = $request->input('date_issued_mode', 'month_year');
        if ($dateMode === 'month_year') {
            $request->validate([
                'date_issued_from_month' => 'required|integer|min:1|max:12',
                'date_issued_to_month' => 'required|integer|min:1|max:12',
                'date_issued_to_year' => 'required|integer|min:1900|max:2100',
            ]);
        } else {
            // year_only
            $validated['date_issued_from_month'] = null;
            $validated['date_issued_to_month'] = null;
            $validated['date_issued_to_year'] = null;
        }

        // Custom validation for location fields based on format
        if ($request->has('format') && is_array($request->format)) {
            foreach ($request->format as $index => $format) {
                if ($format === 'Print') {
                    // For Print format, text_availability and mode_of_access are required
                    if (empty($request->text_availability[$index])) {
                        return back()->withErrors(["text_availability.{$index}" => 'Text availability is required for Print format.']);
                    }

                    if (empty($request->mode_of_access[$index])) {
                        return back()->withErrors(["mode_of_access.{$index}" => 'Mode of access is required for Print format.']);
                    }

                    // If mode is "Request to Institution", email is required
                    if ($request->mode_of_access[$index] === 'Request to Institution' && empty($request->institutional_email[$index])) {
                        return back()->withErrors(["institutional_email.{$index}" => 'Institutional email is required when mode of access is "Request to Institution".']);
                    }
                } elseif ($format === 'Non-Print') {
                    // For Non-Print format, physical_location and text_availability are required
                    if (empty($request->physical_location[$index])) {
                        return back()->withErrors(["physical_location.{$index}" => 'Physical location is required for Non-Print format.']);
                    }

                    if (empty($request->text_availability[$index])) {
                        return back()->withErrors(["text_availability.{$index}" => 'Text availability is required for Non-Print format.']);
                    }

                    // Mode of access is also required for Non-Print, same as Print
                    if (empty($request->mode_of_access[$index])) {
                        return back()->withErrors(["mode_of_access.{$index}" => 'Mode of access is required for Non-Print format.']);
                    }

                    // If mode is "Request to Institution", email is required
                    if ($request->mode_of_access[$index] === 'Request to Institution' && empty($request->institutional_email[$index])) {
                        return back()->withErrors(["institutional_email.{$index}" => 'Institutional email is required when mode of access is "Request to Institution".']);
                    }
                }
            }
        }

        // Always auto-generate accession number server-side with retry on collision
        $attempts = 0;
        $created = false;
        $healthResearch = null;

        while (!$created && $attempts < 5) {
            $attempts++;
            $validated['accession_no'] = $this->generateNextAccessionNo();
            // Serialize checkbox arrays
            $validated['sdg_addressed'] = $this->implodeArray($request->input('sdg_addressed', []));
            $validated['nuhra_addressed'] = $this->implodeArray($request->input('nuhra_addressed', []));
            $validated['mthria_addressed'] = $this->implodeArray($request->input('mthria_addressed', []));
            $validated['agenda_addressed'] = $this->implodeArray($request->input('agenda_addressed', []));
            // status is a single field for the whole research; keep as-is
            try {
                $healthResearch = HealthResearch::create($validated);
                $created = true;
                Log::info('HealthResearch created', ['id' => $healthResearch->id]);
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error('Failed to create HealthResearch', ['error' => $e->getMessage()]);
                if (strpos($e->getMessage(), 'accession_no') === false) {
                    throw $e;
                }
            }
        }

        if (!$created) {
            Log::error('Failed to generate a unique accession number after 5 attempts');
            return back()->withErrors(['accession_no' => 'Failed to generate a unique accession number. Please try again.']);
        }

        // Handle authors
        if ($request->has('author_last_name') && is_array($request->author_last_name)) {
            foreach ($request->author_last_name as $index => $lastName) {
                if (!empty($lastName)) {
                    $healthResearch->authors()->create([
                        'last_name' => $lastName,
                        'first_name' => $request->author_first_name[$index] ?? null,
                        'middle_name' => $request->author_middle_name[$index] ?? null,
                        'suffix' => $request->author_suffix[$index] ?? null,
                    ]);
                }
            }
            Log::info('Authors created for HealthResearch', ['id' => $healthResearch->id]);
        }

        // Handle locations
        if ($request->has('format') && is_array($request->format)) {
            foreach ($request->format as $index => $format) {
                if (!empty($format)) {
                    // Robustly handle checkboxes and file upload
                    $enterUrl = isset($request->enter_url[$index]) ? true : false;
                    $uploadFile = isset($request->upload_file[$index]) ? true : false;
                    $url = $enterUrl ? ($request->url[$index] ?? null) : null;
                    $filePath = null;
                    $fileName = null;
                    if ($uploadFile && $request->hasFile("file.{$index}")) {
                        $file = $request->file("file.{$index}");
                        $fileName = $file->getClientOriginalName();
                        $filePath = $file->store('health_research_files', 'public');
                    }

                    // Additional validation for Non-Print
                    if ($format === 'Non-Print') {
                        if ($enterUrl && empty($url)) {
                            return back()->withErrors(["url.{$index}" => 'URL is required when Enter URL is checked for Non-Print.'])->withInput();
                        }
                        if ($uploadFile && !$request->hasFile("file.{$index}")) {
                            return back()->withErrors(["file.{$index}" => 'File is required when Upload File is checked for Non-Print.'])->withInput();
                        }
                        // If neither is checked, require at least one
                        if (!$enterUrl && !$uploadFile) {
                            return back()->withErrors(["enter_url.{$index}" => 'Please select at least Enter URL or Upload File for Non-Print.'])->withInput();
                        }
                    }

                    $healthResearch->locations()->create([
                        'format' => $format,
                        'physical_location' => $request->physical_location[$index] ?? null,
                        'location_number' => $request->location_number[$index] ?? null,
                        'text_availability' => $request->text_availability[$index] ?? null,
                        'mode_of_access' => $request->mode_of_access[$index] ?? null,
                        'institutional_email' => $request->institutional_email[$index] ?? null,
                        'enter_url' => $enterUrl,
                        'url' => $url,
                        'upload_file' => $uploadFile,
                        'file_path' => $filePath,
                        'file_name' => $fileName,
                    ]);
                }
            }
            Log::info('Locations created for HealthResearch', ['id' => $healthResearch->id]);
        }

        Log::info('Redirecting after successful save', ['id' => $healthResearch->id]);
        return redirect()->route('research.health_researches.index')
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

    private function implodeArray($value): ?string
    {
        if (is_array($value)) {
            return implode('; ', array_values(array_filter($value, function ($v) {
                return $v !== null && $v !== '';
            })));
        }
        return $value ?: null;
    }

    /**
     * Display the specified health research.
     */
    public function show(HealthResearch $healthResearch): View
    {
        return view('research.health_researches.show', compact('healthResearch'));
    }

    /**
     * Display the specified health research for public/guest access by accession_no.
     */
    public function publicShow($accession_no)
    {
        $healthResearch = HealthResearch::where('accession_no', $accession_no)->first();
        if (!$healthResearch) {
            abort(404);
        }
        return view('research.health_researches.show_public', compact('healthResearch'));
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
            'accession_no' => 'nullable|string|max:20|unique:health_researches,accession_no,' . $healthResearch->id,
            'research_title' => 'required|string|max:500',
            'subtitle' => 'nullable|string|max:500',
            'date_issued_from_month' => 'nullable|integer|min:1|max:12',
            'date_issued_from_year' => 'required|integer|min:1900|max:2100',
            'date_issued_to_month' => 'nullable|integer|min:1|max:12',
            'date_issued_to_year' => 'nullable|integer|min:1900|max:2100',
            'volume_no' => 'nullable|string|max:50',
            'issue_no' => 'nullable|string|max:50',
            'pages' => 'nullable|string|max:50',
            'article_no' => 'nullable|string|max:50',
            'doi' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'research_category' => 'required|in:Institutional,Collaborative,Commissioned',
            'research_type' => 'required|in:Basic,Applied,Experimental',
            'abstract_type' => 'nullable|string|max:100',
            'research_abstract' => 'nullable|string',
            'reference' => 'nullable|string',
            'mesh_keywords' => 'nullable|string',
            'non_mesh_keywords' => 'nullable|string',
            'sdg_addressed' => 'required|array|min:1',
            'sdg_addressed.*' => 'nullable|string',
            'nuhra_addressed' => 'required|array|min:1',
            'nuhra_addressed.*' => 'nullable|string',
            'nuhra_others' => 'nullable|string|max:255',
            'mthria_addressed' => 'required|array|min:1',
            'mthria_addressed.*' => 'nullable|string',
            'mthria_others' => 'nullable|string|max:255',
            'agenda_addressed' => 'nullable|array',
            'agenda_addressed.*' => 'nullable|string',
            'implementing_agency' => 'nullable|string|max:255',
            'cooperating_agency' => 'nullable|string|max:255',
            'funding_agency' => 'nullable|string|max:255',
            'is_gov_fund' => 'nullable|in:yes,no',
            'budget' => 'nullable|numeric|min:0',
            'currency_code' => 'nullable|string|max:10',
            // removed: general_note, fund_information, duration, start_date,
            // end_date, year_end_date, keywords, policy_brief, final_report
            'status' => 'nullable|string|max:100',
            // removed: citation, upload_status, remarks
            // Author fields
            'author_last_name' => 'nullable|array',
            'author_last_name.*' => 'nullable|string|max:100',
            'author_first_name' => 'nullable|array',
            'author_first_name.*' => 'nullable|string|max:100',
            'author_middle_name' => 'nullable|array',
            'author_middle_name.*' => 'nullable|string|max:100',
            'author_suffix' => 'nullable|array',
            'author_suffix.*' => 'nullable|string|max:20',
            // Location fields
            'format' => 'required|array|min:1',
            'format.*' => 'required|string|in:Print,Non-Print',
            'physical_location' => 'nullable|array',
            'physical_location.*' => 'nullable|string|max:255',
            'location_number' => 'nullable|array',
            'location_number.*' => 'nullable|string|max:50',
            'text_availability' => 'nullable|array',
            'text_availability.*' => 'nullable|string|in:Abstract Only,Full-text',
            'mode_of_access' => 'nullable|array',
            'mode_of_access.*' => 'nullable|string|max:100',
            'institutional_email' => 'nullable|array',
            'institutional_email.*' => 'nullable|email|max:255',
            'enter_url' => 'nullable|array',
            'enter_url.*' => 'nullable|boolean',
            'url' => 'nullable|array',
            'url.*' => 'nullable|url|max:255',
            'upload_file' => 'nullable|array',
            'upload_file.*' => 'nullable|boolean',
            'file' => 'nullable|array',
            'file.*' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Custom validation for location fields based on format
        if ($request->has('format') && is_array($request->format)) {
            foreach ($request->format as $index => $format) {
                if ($format === 'Print') {
                    // For Print format, text_availability and mode_of_access are required
                    if (empty($request->text_availability[$index])) {
                        return back()->withErrors(["text_availability.{$index}" => 'Text availability is required for Print format.']);
                    }

                    if (empty($request->mode_of_access[$index])) {
                        return back()->withErrors(["mode_of_access.{$index}" => 'Mode of access is required for Print format.']);
                    }

                    // If mode is "Request to Institution", email is required
                    if ($request->mode_of_access[$index] === 'Request to Institution' && empty($request->institutional_email[$index])) {
                        return back()->withErrors(["institutional_email.{$index}" => 'Institutional email is required when mode of access is "Request to Institution".']);
                    }
                } elseif ($format === 'Non-Print') {
                    // For Non-Print format, physical_location and text_availability are required
                    if (empty($request->physical_location[$index])) {
                        return back()->withErrors(["physical_location.{$index}" => 'Physical location is required for Non-Print format.']);
                    }

                    if (empty($request->text_availability[$index])) {
                        return back()->withErrors(["text_availability.{$index}" => 'Text availability is required for Non-Print format.']);
                    }

                    // Mode of access is also required for Non-Print, same as Print
                    if (empty($request->mode_of_access[$index])) {
                        return back()->withErrors(["mode_of_access.{$index}" => 'Mode of access is required for Non-Print format.']);
                    }

                    // If mode is "Request to Institution", email is required
                    if ($request->mode_of_access[$index] === 'Request to Institution' && empty($request->institutional_email[$index])) {
                        return back()->withErrors(["institutional_email.{$index}" => 'Institutional email is required when mode of access is "Request to Institution".']);
                    }
                }
            }
        }

        // Conditional date rules depending on mode
        $dateMode = $request->input('date_issued_mode', 'month_year');
        if ($dateMode === 'month_year') {
            $request->validate([
                'date_issued_from_month' => 'required|integer|min:1|max:12',
                'date_issued_to_month' => 'required|integer|min:1|max:12',
                'date_issued_to_year' => 'required|integer|min:1900|max:2100',
            ]);
        } else {
            $validated['date_issued_from_month'] = null;
            $validated['date_issued_to_month'] = null;
            $validated['date_issued_to_year'] = null;
        }

        // Serialize checkbox arrays
        $validated['sdg_addressed'] = $this->implodeArray($request->input('sdg_addressed', []));
        $validated['nuhra_addressed'] = $this->implodeArray($request->input('nuhra_addressed', []));
        $validated['mthria_addressed'] = $this->implodeArray($request->input('mthria_addressed', []));
        $validated['agenda_addressed'] = $this->implodeArray($request->input('agenda_addressed', []));

        // status is a single field for the whole research; keep as-is

        $healthResearch->update($validated);

        // Handle authors update
        if ($request->has('author_last_name') && is_array($request->author_last_name)) {
            // Delete existing authors
            $healthResearch->authors()->delete();

            // Create new authors
            foreach ($request->author_last_name as $index => $lastName) {
                if (!empty($lastName)) {
                    $healthResearch->authors()->create([
                        'last_name' => $lastName,
                        'first_name' => $request->author_first_name[$index] ?? null,
                        'middle_name' => $request->author_middle_name[$index] ?? null,
                        'suffix' => $request->author_suffix[$index] ?? null,
                    ]);
                }
            }
        }

        // Handle locations update
        if ($request->has('format') && is_array($request->format)) {
            // Delete existing locations
            $healthResearch->locations()->delete();

            // Create new locations
            foreach ($request->format as $index => $format) {
                if (!empty($format)) {
                    // Handle file uploads
                    $filePath = null;
                    $fileName = null;
                    if ($request->hasFile("file.{$index}")) {
                        $file = $request->file("file.{$index}");
                        $fileName = $file->getClientOriginalName();
                        $filePath = $file->store('health_research_files', 'public');
                    }

                    $healthResearch->locations()->create([
                        'format' => $format,
                        'physical_location' => $request->physical_location[$index] ?? null,
                        'location_number' => $request->location_number[$index] ?? null,
                        'text_availability' => $request->text_availability[$index] ?? null,
                        'mode_of_access' => $request->mode_of_access[$index] ?? null,
                        'institutional_email' => $request->institutional_email[$index] ?? null,
                        'enter_url' => $request->enter_url[$index] ?? false,
                        'url' => $request->url[$index] ?? null,
                        'upload_file' => $request->upload_file[$index] ?? false,
                        'file_path' => $filePath,
                        'file_name' => $fileName,
                    ]);
                }
            }
        }

        return redirect()->route('research.health_researches.index')
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
                'title' => $healthResearch['research_title'],
                'author' => $healthResearch['author'] ?? null,
                'isbn' => $healthResearch['accession_no'] ?? null,
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
