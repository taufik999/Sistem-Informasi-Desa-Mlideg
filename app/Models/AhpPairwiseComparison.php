<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AhpPairwiseComparison extends Model
{
    protected $table = 'ahp_pairwise_comparisons';

    protected $fillable = [
        'criteria_1_id',
        'criteria_2_id',
        'comparison_value',
        'consistency_ratio'
    ];

    protected $casts = [
        'comparison_value' => 'decimal:4',
        'consistency_ratio' => 'decimal:4'
    ];

    /**
     * Get the first criteria
     */
    public function criteria1()
    {
        return $this->belongsTo(AhpCriteria::class, 'criteria_1_id');
    }

    /**
     * Get the second criteria
     */
    public function criteria2()
    {
        return $this->belongsTo(AhpCriteria::class, 'criteria_2_id');
    }
}
