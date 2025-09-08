<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthResearchLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_research_id',
        'format',
        'physical_location',
        'location_number',
        'text_availability',
        'mode_of_access',
        'institutional_email',
        'enter_url',
        'url',
        'upload_file',
        'file_path',
        'file_name',
    ];

    protected $casts = [
        'enter_url' => 'boolean',
        'upload_file' => 'boolean',
    ];

    /**
     * Get the health research that owns the location.
     */
    public function healthResearch(): BelongsTo
    {
        return $this->belongsTo(HealthResearch::class);
    }
}
