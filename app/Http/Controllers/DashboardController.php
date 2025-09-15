<?php

namespace App\Http\Controllers;

use App\Models\HealthResearch;
use App\Models\SubmittedHealthResearch;
use App\Models\PendingUser;
use App\Models\User;
use App\Models\SurveyResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_health_researches' => HealthResearch::count(),
            'researches_added_7d' => HealthResearch::where('created_at', '>=', now()->subDays(7))->count(),
            'submitted_researches' => SubmittedHealthResearch::count(),
            'pending_users' => PendingUser::where('approval_status', 'pending')->count(),
            'total_users' => User::count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'survey_total' => SurveyResponse::count(),
            'survey_today' => SurveyResponse::whereDate('created_at', now()->toDateString())->count(),
        ];

        $recent_health_researches = HealthResearch::with('authors')
            ->latest()
            ->take(5)
            ->get(['id', 'research_title', 'status', 'created_at']);

        $recent_users = User::latest()->take(5)->get(['id', 'first_name', 'last_name', 'email', 'email_verified_at']);
        $recent_pending_users = PendingUser::where('approval_status', 'pending')
            ->latest()
            ->take(5)
            ->get(['id', 'first_name', 'last_name', 'email', 'created_at']);
        $recent_submissions = SubmittedHealthResearch::latest()->take(5)->get(['id', 'title', 'author', 'submitted_at']);
        $recent_survey_responses = SurveyResponse::latest()->take(5)->get(['id', 'sex', 'age', 'sector', 'satisfaction', 'created_at']);

        $breakdowns = [
            'status' => HealthResearch::select('status as label', DB::raw('COUNT(*) as total'))
                ->groupBy('status')
                ->orderByDesc('total')
                ->get(),
            'sdg_addressed' => HealthResearch::query()
                ->select('ref_sdgs.sdg_desc as label', 'ref_sdgs.sdg_code as code', DB::raw('COUNT(*) as total'))
                ->leftJoin('ref_sdgs', 'ref_sdgs.sdg_code', '=', 'health_researches.sdg_addressed')
                ->whereNotNull('health_researches.sdg_addressed')
                ->groupBy('ref_sdgs.sdg_desc', 'ref_sdgs.sdg_code')
                ->orderByDesc('total')
                ->take(10)
                ->get(),
            'nuhra_addressed' => HealthResearch::query()
                ->select('ref_nuhra.nuhra_desc as label', 'ref_nuhra.nuhra_code as code', DB::raw('COUNT(*) as total'))
                ->leftJoin('ref_nuhra', 'ref_nuhra.nuhra_code', '=', 'health_researches.nuhra_addressed')
                ->whereNotNull('health_researches.nuhra_addressed')
                ->groupBy('ref_nuhra.nuhra_desc', 'ref_nuhra.nuhra_code')
                ->orderByDesc('total')
                ->take(10)
                ->get(),
            'mthria_addressed' => HealthResearch::query()
                ->select('ref_mthria.mthria_desc as label', 'ref_mthria.mthria_code as code', DB::raw('COUNT(*) as total'))
                ->leftJoin('ref_mthria', 'ref_mthria.mthria_code', '=', 'health_researches.mthria_addressed')
                ->whereNotNull('health_researches.mthria_addressed')
                ->groupBy('ref_mthria.mthria_desc', 'ref_mthria.mthria_code')
                ->orderByDesc('total')
                ->take(10)
                ->get(),
            'agenda_addressed' => HealthResearch::query()
                ->select('ref_agenda.agenda_desc as label', 'ref_agenda.agenda_code as code', DB::raw('COUNT(*) as total'))
                ->leftJoin('ref_agenda', 'ref_agenda.agenda_code', '=', 'health_researches.agenda_addressed')
                ->whereNotNull('health_researches.agenda_addressed')
                ->groupBy('ref_agenda.agenda_desc', 'ref_agenda.agenda_code')
                ->orderByDesc('total')
                ->take(10)
                ->get(),
        ];

        return view('dashboard', compact(
            'stats',
            'recent_health_researches',
            'recent_users',
            'recent_pending_users',
            'recent_submissions',
            'recent_survey_responses',
            'breakdowns'
        ));
    }
}


