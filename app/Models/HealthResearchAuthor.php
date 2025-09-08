<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthResearchAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_research_id',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
    ];

    /**
     * Get the health research that owns the author.
     */
    public function healthResearch(): BelongsTo
    {
        return $this->belongsTo(HealthResearch::class);
    }

    /**
     * Get the full name of the author.
     */
    public function getFullNameAttribute(): string
    {
        $name = trim($this->first_name . ' ' . $this->middle_name);
        $name = trim($name . ' ' . $this->last_name);
        if ($this->suffix) {
            $name .= ', ' . $this->suffix;
        }
        return $name;
    }
}
