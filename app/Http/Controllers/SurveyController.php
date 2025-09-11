<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    /**
     * Check if IP has already submitted a survey or seen it today.
     */
    public function checkIpStatus(Request $request)
    {
        $ipAddress = $request->ip();
        $today = now()->toDateString();

        // Check if IP has submitted a survey
        $hasSubmitted = SurveyResponse::where('ip_address', $ipAddress)
            ->whereNotNull('sex') // Has actual survey data
            ->exists();

        // Check if IP has seen survey today (even if not submitted)
        $hasSeenToday = SurveyResponse::where('ip_address', $ipAddress)
            ->where('survey_shown_date', $today)
            ->exists();

        return response()->json([
            'has_submitted' => $hasSubmitted,
            'has_seen_today' => $hasSeenToday
        ]);
    }

    /**
     * Mark that survey was shown to this IP today.
     */
    public function markSurveyShown(Request $request)
    {
        $ipAddress = $request->ip();
        $today = now()->toDateString();

        // Check if we already have a record for this IP today
        $existingRecord = SurveyResponse::where('ip_address', $ipAddress)
            ->where('survey_shown_date', $today)
            ->first();

        if (!$existingRecord) {
            // Create a record to track that survey was shown today
            SurveyResponse::create([
                'ip_address' => $ipAddress,
                'user_agent' => $request->userAgent(),
                'survey_shown_date' => $today,
                // Leave other fields null since this is just tracking
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Store a new survey response.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sex' => 'required|string|in:Male,Female',
            'age' => 'required|string',
            'sector' => 'required|string',
            'reason' => 'required|string',
            'satisfaction' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill in all required fields.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $surveyResponse = SurveyResponse::create([
                'sex' => $request->sex,
                'age' => $request->age,
                'sector' => $request->sector,
                'reason' => $request->reason,
                'satisfaction' => $request->satisfaction,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'survey_shown_date' => now()->toDateString(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your feedback! Your response has been recorded.',
                'data' => $surveyResponse
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving your response. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
