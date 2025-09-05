<?php

use Illuminate\Support\Facades\Route;
use App\Models\HealthResearch;

Route::get('/health_researches', function () {
    return response()->json(\App\Models\HealthResearch::all());
});
