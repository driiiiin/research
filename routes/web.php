<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPendingUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function (Request $request) {
    $healthResearches = null;

    // Only fetch health researches if there's a search query
    if ($request->filled('search') || $request->filled('format')) {
        $query = \App\Models\HealthResearch::where('status', 'Available');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }

        $healthResearches = $query->latest()->paginate(12);
    }

    return view('page.welcome', compact('healthResearches'));
})->name('welcome');

Route::get('/contact', function () {
    return view('page.contact');
})->name('contact');

Route::get('/about', function () {
    return view('page.about');
})->name('about');

Route::get('/dashboard', function () {
    $stats = [
        'total_health_researches' => \App\Models\HealthResearch::count(),
    ];
    $recent_health_researches = \App\Models\HealthResearch::latest()->take(5)->get();
    return view('dashboard', compact('stats', 'recent_health_researches'));
})->middleware(['auth', 'verified', 'prevent-back'])->name('dashboard');

// Make next-accession public and accessible to AJAX
Route::prefix('research')->name('research.')->group(function () {
    Route::get('/health_researches/next-accession', [App\Http\Controllers\HealthResearchController::class, 'nextAccession'])
        ->name('health_researches.next_accession');
});

Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // research System Routes
    Route::prefix('research')->name('research.')->group(function () {
        Route::get('/', [App\Http\Controllers\HealthResearchController::class, 'index'])->name('index');

        // Health Researches
        Route::resource('health_researches', App\Http\Controllers\HealthResearchController::class);

        // Partials for dynamic sections
        Route::get('/health_researches/partials/source', function (Illuminate\Http\Request $request) {
            $index = (int) $request->get('index', 0);
            $subtypes = [];
            return view('research.health_researches.partials.source', compact('index', 'subtypes'));
        })->name('health_researches.partials.source');

        Route::get('/health_researches/partials/author', function (Illuminate\Http\Request $request) {
            $index = (int) $request->get('index', 0);
            return view('research.health_researches.partials.author', compact('index'));
        })->name('health_researches.partials.author');

        Route::get('/health_researches/partials/location', function (Illuminate\Http\Request $request) {
            $index = (int) $request->get('index', 0);
            return view('research.health_researches.partials.location', compact('index'));
        })->name('health_researches.partials.location');
    });

    // Users
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::post('/users/{user}/logout-session', [App\Http\Controllers\UserController::class, 'logoutSession'])->name('users.logoutSession');

    // Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/pending-users', [AdminPendingUserController::class, 'index'])->name('admin.pending-users.index');
        Route::patch('/admin/pending-users/{pendingUser}/approve', [AdminPendingUserController::class, 'approve'])->name('admin.pending-users.approve');
        Route::delete('/admin/pending-users/{pendingUser}/reject', [AdminPendingUserController::class, 'reject'])->name('admin.pending-users.reject');
    });
});

// Health Researches Submit Page for External System
Route::get('/health_researches/submit', [App\Http\Controllers\HealthResearchController::class, 'submitPage'])->name('health_researches.submit.page');
Route::post('/health_researches/submit-health-researches', [App\Http\Controllers\HealthResearchController::class, 'submitHealthResearches'])->name('health_researches.submit.health_researches');

require __DIR__.'/auth.php';
