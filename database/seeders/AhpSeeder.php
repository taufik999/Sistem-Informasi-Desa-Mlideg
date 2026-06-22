<?php

namespace Database\Seeders;

use App\Services\AhpService;
use Illuminate\Database\Seeder;

class AhpSeeder extends Seeder
{
    /**
     * Seed the AHP tables with sample data for testing
     * 
     * Run: php artisan db:seed --class=AhpSeeder
     */
    public function run(): void
    {
        $ahpService = new AhpService();

        // Step 1: Initialize default criteria
        echo "Initializing AHP criteria...\n";
        $ahpService->initializeDefaultCriteria();

        // Step 2: Setup pairwise comparisons
        echo "Setting up pairwise comparisons...\n";
        $ahpService->savePairwiseComparison(1, 2, 3);  // Dampak 3x lebih penting dari Urgensi
        $ahpService->savePairwiseComparison(1, 3, 5);  // Dampak 5x lebih penting dari Kompleksitas
        $ahpService->savePairwiseComparison(2, 3, 2);  // Urgensi 2x lebih penting dari Kompleksitas

        // Step 3: Calculate criteria weights
        echo "Calculating criteria weights...\n";
        $result = $ahpService->calculateCriteriaWeights();
        
        echo "Consistency Ratio: " . number_format($result['consistency_ratio'], 4) . "\n";
        echo "Status: " . ($result['is_consistent'] ? "✓ Konsisten" : "✗ Tidak Konsisten") . "\n";

        // Step 4: Sample assessments for demonstration
        // These would typically come from admin input
        echo "Adding sample report assessments...\n";

        $sampleReports = [
            [
                'track_id' => 'LPR-DEMO001',
                'assessments' => [1 => 8, 2 => 9, 3 => 6]
            ],
            [
                'track_id' => 'LPR-DEMO002',
                'assessments' => [1 => 5, 2 => 6, 3 => 2]
            ],
            [
                'track_id' => 'LPR-DEMO003',
                'assessments' => [1 => 7, 2 => 7, 3 => 7]
            ]
        ];

        foreach ($sampleReports as $report) {
            foreach ($report['assessments'] as $criteriaId => $score) {
                $ahpService->saveReportAssessment(
                    $report['track_id'],
                    $criteriaId,
                    $score
                );
            }
        }

        // Step 5: Calculate report priorities
        echo "Calculating report priorities...\n";
        $ahpService->calculateReportPriorities();

        // Display results
        echo "\n=== AHP SETUP COMPLETE ===\n";
        echo "Criteria Weights:\n";
        $weights = $ahpService->getCriteriaWeights();
        foreach ($weights as $name => $weight) {
            echo "  - {$name}: " . number_format($weight * 100, 2) . "%\n";
        }

        echo "\nTop Priority Reports:\n";
        $topReports = $ahpService->getTopPriorityReports(3);
        foreach ($topReports as $report) {
            echo "  - {$report['report_id']}: " . number_format($report['ahp_score'], 4) . "\n";
        }
    }
}
