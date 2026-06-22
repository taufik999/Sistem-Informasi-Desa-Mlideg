<?php

namespace App\Services;

use App\Models\AhpCriteria;
use App\Models\AhpPairwiseComparison;
use App\Models\AhpReportAssessment;
use App\Models\ReportPriority;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Schema;

class AhpService
{
    private static array $randomIndex = [
        1 => 0.00,
        2 => 0.00,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49
    ];

    public function __construct()
    {
        // Ensure default criteria exist if table is empty
        if (AhpCriteria::count() === 0) {
            $this->initializeDefaultCriteria();
        }
    }

    public function getActiveCriteria()
    {
        return AhpCriteria::active()->ordered()->get();
    }
    
    public function getAllCriteria()
    {
        return AhpCriteria::ordered()->get();
    }

    public function calculateCriteriaWeights(): array
    {
        $activeCriteria = $this->getActiveCriteria();
        
        if ($activeCriteria->isEmpty()) {
            return [
                'weights' => [],
                'lambda' => 0,
                'consistency_index' => 0,
                'consistency_ratio' => 0,
                'is_consistent' => true,
            ];
        }

        $n = $activeCriteria->count();

        // Cek apakah ada data pairwise comparison
        // Jika tidak ada, gunakan bobot yang sudah tersimpan di database (default weights)
        // agar tidak menimpa bobot default (Dampak:40%, Urgensi:30%, Lama Menunggu:20%, Kompleksitas:10%)
        $pairwiseCount = AhpPairwiseComparison::count();
        
        if ($pairwiseCount === 0) {
            // Tidak ada data perbandingan berpasangan, kembalikan bobot yang sudah ada
            $existingWeights = [];
            foreach ($activeCriteria as $c) {
                $existingWeights[$c->id] = $c->weight ?? 0;
            }
            
            return [
                'weights' => $existingWeights,
                'lambda' => 0,
                'consistency_index' => 0,
                'consistency_ratio' => 0,
                'is_consistent' => true,
            ];
        }

        $matrix = $this->buildComparisonMatrix($activeCriteria);
        $normalizedMatrix = $this->normalizeMatrix($matrix);

        $weights = [];
        foreach ($activeCriteria as $index => $criteria) {
            $weights[$criteria->id] = array_sum($normalizedMatrix[$index]) / $n;
        }

        $lambda = $this->calculateLambda($matrix, $weights, $activeCriteria);
        $ci = $n > 1 ? ($lambda - $n) / ($n - 1) : 0;
        $ri = self::$randomIndex[$n] ?? 0;
        $cr = $ri > 0 ? $ci / $ri : 0;

        // Update weights in database
        foreach ($activeCriteria as $c) {
            if (isset($weights[$c->id])) {
                $c->update(['weight' => $weights[$c->id]]);
            }
        }

        return [
            'weights' => $weights,
            'lambda' => $lambda,
            'consistency_index' => $ci,
            'consistency_ratio' => $cr,
            'is_consistent' => $cr <= 0.1,
        ];
    }

    private function buildComparisonMatrix($criteria): array
    {
        $matrix = [];
        $comparisons = AhpPairwiseComparison::all();

        foreach ($criteria as $i => $criteria1) {
            $matrix[$i] = [];
            foreach ($criteria as $j => $criteria2) {
                if ($i === $j) {
                    $matrix[$i][$j] = 1;
                } else {
                    $val = 1;
                    foreach ($comparisons as $comp) {
                        if ($comp->criteria_1_id == $criteria1->id && $comp->criteria_2_id == $criteria2->id) {
                            $val = $comp->comparison_value;
                            break;
                        } elseif ($comp->criteria_1_id == $criteria2->id && $comp->criteria_2_id == $criteria1->id) {
                            $val = 1 / $comp->comparison_value;
                            break;
                        }
                    }
                    $matrix[$i][$j] = $val;
                }
            }
        }
        return $matrix;
    }

    private function normalizeMatrix(array $matrix): array
    {
        $n = count($matrix);
        $normalized = [];
        $columnSums = array_fill(0, $n, 0);
        foreach ($matrix as $row) {
            foreach ($row as $j => $value) {
                $columnSums[$j] += $value;
            }
        }
        foreach ($matrix as $i => $row) {
            $normalized[$i] = [];
            foreach ($row as $j => $value) {
                $normalized[$i][$j] = $columnSums[$j] > 0 ? $value / $columnSums[$j] : 0;
            }
        }
        return $normalized;
    }

    private function calculateLambda(array $matrix, array $weights, $criteria): float
    {
        $lambda = 0;
        $n = count($criteria);
        if ($n == 0) return 0;

        foreach ($criteria as $i => $criteria1) {
            $weightedSum = 0;
            foreach ($criteria as $j => $criteria2) {
                $weightedSum += $matrix[$i][$j] * ($weights[$criteria2->id] ?? 0);
            }
            if (($weights[$criteria1->id] ?? 0) > 0) {
                $lambda += $weightedSum / $weights[$criteria1->id];
            }
        }
        return $lambda / $n;
    }

    public function calculateReportPriorities(): array
    {
        $reportPriorities = [];
        $reports = Pengaduan::all();
        $criteria = AhpCriteria::active()->get();

        foreach ($reports as $report) {
            $score = 0;
            $assessments = AhpReportAssessment::where('report_id', $report->track_id)->get();
            
            foreach ($assessments as $assessment) {
                $crit = $criteria->firstWhere('id', $assessment->criteria_id);
                $weight = $crit ? $crit->weight : 0;
                $score += $assessment->score * $weight;
            }

            // Normalized to 0-100% scale
            $normalizedScore = round(($score / 9) * 100, 4);

            ReportPriority::updateOrCreate(
                ['report_id' => $report->track_id],
                [
                    'ahp_score' => $normalizedScore,
                    'last_calculated_at' => now()
                ]
            );
            
            $reportPriorities[$report->track_id] = $normalizedScore;
        }

        $this->assignPriorityRanks();

        return $reportPriorities;
    }

    private function assignPriorityRanks(): void
    {
        $priorities = ReportPriority::orderBy('ahp_score', 'desc')->get();
        
        foreach ($priorities as $index => $priority) {
            $priority->update(['priority_rank' => $index + 1]);
        }
    }

    public function savePairwiseComparison(int $criteria1Id, int $criteria2Id, float $value): void
    {
        // First delete any inverse comparison to avoid conflicts
        AhpPairwiseComparison::where('criteria_1_id', $criteria2Id)
                             ->where('criteria_2_id', $criteria1Id)
                             ->delete();

        AhpPairwiseComparison::updateOrCreate(
            [
                'criteria_1_id' => $criteria1Id,
                'criteria_2_id' => $criteria2Id
            ],
            [
                'comparison_value' => $value
            ]
        );
    }

    public function saveReportAssessment(string $reportId, int $criteriaId, float $score): void
    {
        AhpReportAssessment::updateOrCreate(
            [
                'report_id' => $reportId,
                'criteria_id' => $criteriaId
            ],
            [
                'score' => $score
            ]
        );

        // Ensure a ReportPriority record exists
        ReportPriority::firstOrCreate(
            ['report_id' => $reportId],
            ['ahp_score' => 0]
        );
    }

    public function getReportRanking()
    {
        return ReportPriority::byPriority()->get()->toArray();
    }

    public function getTopPriorityReports(int $limit = 5): array
    {
        return ReportPriority::byPriority()->take($limit)->get()->toArray();
    }

    public function getCriteriaWeights(): array
    {
        $criteria = $this->getActiveCriteria();
        $weights = [];
        foreach ($criteria as $c) {
            $weights[$c->name] = $c->weight ?? 0;
        }
        return $weights;
    }

    public function resetAllAhpData(): void
    {
        Schema::disableForeignKeyConstraints();
        AhpReportAssessment::truncate();
        ReportPriority::truncate();
        AhpPairwiseComparison::truncate();
        Schema::enableForeignKeyConstraints();

        // Kembalikan bobot ke default, bukan 0
        // Dampak: 40%, Urgensi: 30%, Lama Menunggu: 20%, Kompleksitas: 10%
        $defaultWeights = [
            'Dampak' => 0.4,
            'Urgensi' => 0.3,
            'Lama Menunggu' => 0.2,
            'Kompleksitas' => 0.1,
        ];

        foreach ($defaultWeights as $name => $weight) {
            AhpCriteria::where('name', $name)->update(['weight' => $weight]);
        }
    }

    public function initializeDefaultCriteria(): void
    {
        Schema::disableForeignKeyConstraints();
        AhpPairwiseComparison::truncate();
        AhpReportAssessment::truncate();
        AhpCriteria::truncate();
        Schema::enableForeignKeyConstraints();
        
        $defaultCriteria = [
            [
                'name' => 'Dampak',
                'description' => 'Seberapa besar dampak dari laporan terhadap masyarakat',
                'order' => 1,
                'is_active' => true,
                'weight' => 0.4
            ],
            [
                'name' => 'Urgensi',
                'description' => 'Seberapa cepat laporan perlu ditangani',
                'order' => 2,
                'is_active' => true,
                'weight' => 0.3
            ],
            [
                'name' => 'Kompleksitas',
                'description' => 'Tingkat kesulitan penyelesaian laporan',
                'order' => 3,
                'is_active' => true,
                'weight' => 0.1
            ],
            [
                'name' => 'Lama Menunggu',
                'description' => 'Berapa lama laporan belum ditangani (Aging Score)',
                'order' => 4,
                'is_active' => true,
                'weight' => 0.2
            ]
        ];

        foreach ($defaultCriteria as $criteria) {
            AhpCriteria::create($criteria);
        }
    }

    public function autoAssessReport(array $report): void
    {
        $criteria = $this->getActiveCriteria();
        if ($criteria->isEmpty()) return;

        $dampakId = null; $urgensiId = null; $kompleksitasId = null; $lamaMenungguId = null;
        foreach ($criteria as $c) {
            if ($c->name == 'Dampak') $dampakId = $c->id;
            if ($c->name == 'Urgensi') $urgensiId = $c->id;
            if ($c->name == 'Kompleksitas') $kompleksitasId = $c->id;
            if ($c->name == 'Lama Menunggu') $lamaMenungguId = $c->id;
        }

        if (!$dampakId || !$urgensiId || !$kompleksitasId) return;

        $kat = strtolower($report['kategori'] ?? '');
        $teks = strtolower(($report['subjek'] ?? '') . ' ' . ($report['pesan'] ?? ''));

        $d = 5; $u = 5; $k = 5; $l = 1;
        
        // 1. Logika Kriteria Lama Menunggu (Aging)
        if ($lamaMenungguId && isset($report['created_at'])) {
            $created_at = \Carbon\Carbon::parse($report['created_at']);
            $daysOld = now()->diffInDays($created_at);
            $l = min(9, 1 + floor($daysOld * 2));
            
            if (isset($report['status']) && $report['status'] !== 'Menunggu Validasi') {
                $l = 1;
            }
        }
        
        // 2. Logika Kategori (existing)
        if (str_contains($kat, 'infrastruktur')) { $d=7; $u=6; $k=8; }
        elseif (str_contains($kat, 'lingkungan')) { $d=6; $u=5; $k=5; }
        elseif (str_contains($kat, 'keamanan') || str_contains($kat, 'bencana')) { $d=8; $u=9; $k=6; }
        elseif (str_contains($kat, 'kesehatan')) { $d=9; $u=9; $k=4; }
        elseif (str_contains($kat, 'sosial')) { $d=5; $u=4; $k=4; }
        elseif (str_contains($kat, 'pelayanan')) { $d=4; $u=4; $k=3; }

        $daruratKeywords = ['darurat', 'gawat', 'bahaya', 'mati total', 'banjir', 'longsor', 'kecelakaan'];
        foreach ($daruratKeywords as $kw) {
            if (str_contains($teks, $kw)) { $d += 2; $u += 2; break; }
        }

        $mendesakKeywords = ['segera', 'cepat', 'mohon', 'tolong'];
        foreach ($mendesakKeywords as $kw) {
            if (str_contains($teks, $kw)) { $u += 1; break; }
        }

        $rusakKeywords = ['rusak parah', 'hancur', 'jebol'];
        foreach ($rusakKeywords as $kw) {
            if (str_contains($teks, $kw)) { $k += 2; $d += 1; break; }
        }

        $sulitKeywords = ['susah', 'sulit', 'rumit', 'bertahun-tahun'];
        foreach ($sulitKeywords as $kw) {
            if (str_contains($teks, $kw)) { $k += 2; break; }
        }

        $d = max(1, min(9, $d));
        $u = max(1, min(9, $u));
        $k = max(1, min(9, $k));
        $l = max(1, min(9, $l));

        $this->saveReportAssessment($report['track_id'], $dampakId, $d);
        $this->saveReportAssessment($report['track_id'], $urgensiId, $u);
        $this->saveReportAssessment($report['track_id'], $kompleksitasId, $k);
        if ($lamaMenungguId) {
            $this->saveReportAssessment($report['track_id'], $lamaMenungguId, $l);
        }

        $this->calculateReportPriorities();
    }

    public function updateAgingScores($reports): void
    {
        $criteria = $this->getActiveCriteria();
        $lamaMenungguId = null;
        foreach ($criteria as $c) {
            if ($c->name == 'Lama Menunggu') $lamaMenungguId = $c->id;
        }

        if (!$lamaMenungguId) return;

        $hasUpdates = false;
        foreach ($reports as $report) {
            if (isset($report['created_at'])) {
                $created_at = \Carbon\Carbon::parse($report['created_at']);
                $daysOld = now()->diffInDays($created_at);
                $l = min(9, 1 + floor($daysOld * 2));
                
                if (isset($report['status']) && $report['status'] !== 'Menunggu Validasi') {
                    $l = 1; 
                }
                
                $l = max(1, min(9, $l));
                $this->saveReportAssessment($report['track_id'], $lamaMenungguId, $l);
                $hasUpdates = true;
            }
        }

        if ($hasUpdates) {
            $this->calculateReportPriorities();
        }
    }
}

