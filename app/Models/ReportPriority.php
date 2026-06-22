<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportPriority extends Model
{
    protected $table = 'report_priorities';

    protected $fillable = [
        'report_id',
        'ahp_score',
        'priority_rank',
        'last_calculated_at'
    ];

    protected $casts = [
        'ahp_score' => 'decimal:4',
        'last_calculated_at' => 'datetime'
    ];

    /**
     * Get all assessments for this report
     */
    public function assessments()
    {
        return $this->hasMany(AhpReportAssessment::class, 'report_id', 'report_id');
    }

    /**
     * Scope: Get reports sorted by priority
     */
    public function scopeByPriority($query)
    {
        return $query->orderBy('priority_rank')->orderBy('ahp_score', 'desc');
    }
}
