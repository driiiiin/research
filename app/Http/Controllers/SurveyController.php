<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
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
