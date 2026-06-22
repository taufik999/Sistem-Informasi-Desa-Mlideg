<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AhpCriteria extends Model
{
    protected $table = 'ahp_criteria';

    protected $fillable = [
        'name',
        'description',
        'weight',
        'order',
        'is_active'
    ];

    protected $casts = [
        'weight' => 'decimal:4',
        'is_active' => 'boolean'
    ];

    /**
     * Get pairwise comparisons for this criteria (as first criteria)
     */
    public function pairwiseComparisonsAsFirst()
    {
        return $this->hasMany(AhpPairwiseComparison::class, 'criteria_1_id');
    }

    /**
     * Get pairwise comparisons for this criteria (as second criteria)
     */
    public function pairwiseComparisonsAsSecond()
    {
        return $this->hasMany(AhpPairwiseComparison::class, 'criteria_2_id');
    }

    /**
     * Get all report assessments for this criteria
     */
    public function reportAssessments()
    {
        return $this->hasMany(AhpReportAssessment::class);
    }

    /**
     * Scope: Get only active criteria
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Order by order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
