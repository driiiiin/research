<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $fillable = [
        'sex',
        'age',
        'sector',
        'reason',
        'satisfaction',
        'ip_address',
        'user_agent',
        'survey_shown_date'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'survey_shown_date' => 'date',
    ];
}
