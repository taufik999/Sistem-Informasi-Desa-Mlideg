<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AhpReportAssessment extends Model
{
    protected $table = 'ahp_report_assessments';

    protected $fillable = [
        'report_id',
        'criteria_id',
        'score'
    ];

    protected $casts = [
        'score' => 'decimal:2'
    ];

    /**
     * Get the criteria
     */
    public function criteria()
    {
        return $this->belongsTo(AhpCriteria::class);
    }

    /**
     * Get the priority for this report
     */
    public function priority()
    {
        return $this->hasOne(ReportPriority::class, 'report_id', 'report_id');
    }
}
