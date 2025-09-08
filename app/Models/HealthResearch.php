<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthResearch extends Model
{
    use HasFactory;

    protected $table = 'health_researches';

    protected $fillable = [
        'accession_no',
        'research_title',
        'subtitle',
        'date_issued_from_month',
        'date_issued_from_year',
        'date_issued_to_month',
        'date_issued_to_year',
        'volume_no',
        'issue_no',
        'pages',
        'article_no',
        'doi',
        'notes',
        'research_category',
        'research_type',
        'abstract_type',
        'research_abstract',
        'reference',
        'mesh_keywords',
        'non_mesh_keywords',
        'sdg_addressed',
        'policy_brief',
        'final_report',
        'implementing_agency',
        'cooperating_agency',
        'general_note',
        'budget',
        'fund_information',
        'duration',
        'start_date',
        'end_date',
        'year_end_date',
        'keywords',
        'status',
        'citation',
        'upload_status',
        'remarks',
    ];

    protected $casts = [
        'subtitle' => 'array',
        'date_issued_from_month' => 'integer',
        'date_issued_from_year' => 'integer',
        'date_issued_to_month' => 'integer',
        'date_issued_to_year' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the authors for the health research.
     */
    public function authors(): HasMany
    {
        return $this->hasMany(HealthResearchAuthor::class);
    }

    /**
     * Get the locations for the health research.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(HealthResearchLocation::class);
    }

}
