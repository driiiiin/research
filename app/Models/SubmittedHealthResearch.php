<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmittedHealthResearch extends Model
{
    protected $table = 'submitted_health_researches';

    protected $fillable = [
        'health_research_id',
        'title',
        'author',
        'isbn',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function healthResearch()
    {
        return $this->belongsTo(HealthResearch::class);
    }
}
