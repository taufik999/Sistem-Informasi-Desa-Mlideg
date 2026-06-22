<?php

/**
 * CONTOH PENGGUNAAN AHP SERVICE
 * 
 * File ini menunjukkan cara menggunakan AhpService secara programatik
 * untuk menghitung prioritas laporan menggunakan metode AHP.
 */

namespace App\Examples;

use App\Services\AhpService;

class AhpUsageExample
{
    protected AhpService $ahpService;

    public function __construct()
    {
        $this->ahpService = new AhpService();
    }

    /**
     * SCENARIO 1: Setup Awal Sistem AHP
     * 
     * Inisialisasi kriteria, lakukan perbandingan, hitung bobot
     */
    public function setupAhpSystem(): void
    {
        echo "=== SCENARIO 1: Setup Awal Sistem AHP ===\n\n";

        // Step 1: Inisialisasi kriteria default
        echo "1. Menginisialisasi kriteria default...\n";
        $this->ahpService->initializeDefaultCriteria();
        echo "✓ Kriteria berhasil dibuat: Dampak, Urgensi, Kompleksitas\n\n";

        // Step 2: Simpan perbandingan berpasangan
        echo "2. Menyimpan perbandingan berpasangan...\n";
        
        // Dampak vs Urgensi: Dampak 3x lebih penting
        $this->ahpService->savePairwiseComparison(
            criteria1Id: 1,  // Dampak
            criteria2Id: 2,  // Urgensi
            value: 3
        );
        echo "   - Dampak vs Urgensi = 3 (Dampak lebih penting)\n";

        // Dampak vs Kompleksitas: Dampak 5x lebih penting
        $this->ahpService->savePairwiseComparison(1, 3, 5);
        echo "   - Dampak vs Kompleksitas = 5 (Dampak jauh lebih penting)\n";

        // Urgensi vs Kompleksitas: Urgensi 2x lebih penting
        $this->ahpService->savePairwiseComparison(2, 3, 2);
        echo "   - Urgensi vs Kompleksitas = 2 (Urgensi lebih penting)\n\n";

        // Step 3: Hitung bobot kriteria
        echo "3. Menghitung bobot kriteria...\n";
        $result = $this->ahpService->calculateCriteriaWeights();

        echo "   Hasil Perhitungan:\n";
        echo "   - Lambda (Eigenvalue): " . number_format($result['lambda'], 4) . "\n";
        echo "   - Consistency Index (CI): " . number_format($result['consistency_index'], 4) . "\n";
        echo "   - Consistency Ratio (CR): " . number_format($result['consistency_ratio'], 4) . "\n";
        echo "   - Status: " . ($result['is_consistent'] ? "✓ Konsisten" : "✗ Tidak Konsisten") . "\n\n";

        echo "   Bobot Kriteria:\n";
        foreach ($result['weights'] as $criteriaId => $weight) {
            echo "   - Kriteria ID {$criteriaId}: " . number_format($weight * 100, 2) . "%\n";
        }
        echo "\n";
    }

    /**
     * SCENARIO 2: Penilaian Laporan
     * 
     * Menilai beberapa laporan berdasarkan kriteria yang sudah disiapkan
     */
    public function assessReports(): void
    {
        echo "=== SCENARIO 2: Penilaian Laporan Warga ===\n\n";

        // Data laporan contoh
        $reports = [
            [
                'track_id' => 'LPR-ABC123',
                'name' => 'Jalan Rusak Parah',
                'assessments' => [
                    1 => 8,  // Dampak: 8 (sangat tinggi - jalan rusak parah)
                    2 => 9,  // Urgensi: 9 (sangat urgent - jalan tidak bisa dilewati)
                    3 => 6   // Kompleksitas: 6 (tinggi - butuh perbaikan besar)
                ]
            ],
            [
                'track_id' => 'LPR-XYZ789',
                'name' => 'Lampu Jalan Mati',
                'assessments' => [
                    1 => 5,  // Dampak: 5 (sedang - keamanan malam hari)
                    2 => 6,  // Urgensi: 6 (tinggi - perlu diperbaiki segera)
                    3 => 2   // Kompleksitas: 2 (rendah - tinggal ganti lampu)
                ]
            ],
            [
                'track_id' => 'LPR-DEF456',
                'name' => 'Drainase Buntu',
                'assessments' => [
                    1 => 7,  // Dampak: 7 (tinggi - menyebabkan banjir)
                    2 => 7,  // Urgensi: 7 (tinggi - musim hujan segera tiba)
                    3 => 7   // Kompleksitas: 7 (tinggi - perlu pembersihan besar)
                ]
            ]
        ];

        echo "Menilai laporan berdasarkan kriteria:\n\n";

        foreach ($reports as $report) {
            echo "Laporan: {$report['track_id']} - {$report['name']}\n";

            foreach ($report['assessments'] as $criteriaId => $score) {
                $this->ahpService->saveReportAssessment(
                    reportId: $report['track_id'],
                    criteriaId: $criteriaId,
                    score: $score
                );
                
                $criteriaName = match($criteriaId) {
                    1 => 'Dampak',
                    2 => 'Urgensi',
                    3 => 'Kompleksitas'
                };
                
                echo "  - {$criteriaName}: {$score}/9\n";
            }
            echo "\n";
        }
    }

    /**
     * SCENARIO 3: Hitung Prioritas dan Ranking
     * 
     * Menghitung skor AHP dan menampilkan ranking laporan
     */
    public function calculateAndShowRanking(): void
    {
        echo "=== SCENARIO 3: Perhitungan Prioritas ===\n\n";

        // Hitung prioritas untuk semua laporan
        echo "Menghitung skor AHP untuk semua laporan...\n";
        $reportPriorities = $this->ahpService->calculateReportPriorities();
        echo "✓ Perhitungan selesai\n\n";

        // Tampilkan hasil ranking
        echo "=== HASIL RANKING LAPORAN ===\n\n";
        
        $ranking = $this->ahpService->getReportRanking();
        
        foreach ($ranking as $index => $report) {
            $rank = $index + 1;
            echo str_repeat("-", 60) . "\n";
            echo "Rank #{$rank}: {$report['report_id']}\n";
            echo "Skor AHP: " . number_format($report['ahp_score'], 4) . "\n";
            
            if ($rank == 1) {
                echo "Status: 🥇 PRIORITAS TERTINGGI - Tangani Terlebih Dahulu\n";
            } elseif ($rank == 2) {
                echo "Status: 🥈 PRIORITAS KEDUA\n";
            } elseif ($rank == 3) {
                echo "Status: 🥉 PRIORITAS KETIGA\n";
            } else {
                echo "Status: Prioritas #{$rank}\n";
            }
            echo "\n";
        }

        // Tampilkan top 3 laporan
        echo "=== TOP 3 LAPORAN YANG HARUS DITANGANI ===\n\n";
        $topReports = $this->ahpService->getTopPriorityReports(3);
        
        foreach ($topReports as $index => $report) {
            echo ($index + 1) . ". {$report['report_id']} (Skor: " . 
                 number_format($report['ahp_score'], 4) . ")\n";
        }
        echo "\n";
    }

    /**
     * SCENARIO 4: Mendapatkan Bobot Kriteria
     */
    public function getWeights(): void
    {
        echo "=== SCENARIO 4: Bobot Kriteria ===\n\n";

        $weights = $this->ahpService->getCriteriaWeights();

        echo "Bobot kriteria yang sedang digunakan:\n\n";
        
        $totalPercentage = 0;
        foreach ($weights as $criteriaName => $weight) {
            $percentage = $weight * 100;
            $totalPercentage += $percentage;
            echo "{$criteriaName}: " . number_format($percentage, 2) . "%\n";
        }
        
        echo "\nTotal: " . number_format($totalPercentage, 2) . "%\n\n";
    }

    /**
     * Jalankan semua scenario
     */
    public function runAll(): void
    {
        try {
            $this->setupAhpSystem();
            echo "\n";
            
            $this->assessReports();
            echo "\n";
            
            $this->calculateAndShowRanking();
            echo "\n";
            
            $this->getWeights();
            
            echo "=== SEMUA SCENARIO SELESAI ===\n";
        } catch (\Exception $e) {
            echo "ERROR: " . $e->getMessage() . "\n";
        }
    }
}

/**
 * PENGGUNAAN DALAM ARTISAN COMMAND
 * 
 * Buat file app/Console/Commands/RunAhpExample.php:
 * 
 * namespace App\Console\Commands;
 * use Illuminate\Console\Command;
 * use App\Examples\AhpUsageExample;
 * 
 * class RunAhpExample extends Command {
 *     protected $signature = 'ahp:example';
 *     protected $description = 'Run AHP usage examples';
 *     
 *     public function handle() {
 *         $example = new AhpUsageExample();
 *         $example->runAll();
 *     }
 * }
 * 
 * Kemudian jalankan: php artisan ahp:example
 */

/**
 * PENGGUNAAN DALAM TESTING
 * 
 * tests/Feature/AhpTest.php
 */
class AhpTest
{
    /**
     * Test: Perhitungan Bobot Kriteria
     */
    public function testCalculateCriteriaWeights()
    {
        // Setup
        $ahpService = new AhpService();
        $ahpService->initializeDefaultCriteria();
        
        // Execute
        $result = $ahpService->calculateCriteriaWeights();
        
        // Assert
        assert($result['is_consistent'] === true, "Penilaian harus konsisten");
        assert(array_sum($result['weights']) <= 1.01, "Total bobot harus 1");
        
        echo "✓ Test Calculate Criteria Weights: PASSED\n";
    }

    /**
     * Test: Perhitungan Skor AHP
     */
    public function testCalculateReportPriorities()
    {
        $ahpService = new AhpService();
        
        // Save assessment
        $ahpService->saveReportAssessment('LPR-TEST', 1, 7);
        $ahpService->saveReportAssessment('LPR-TEST', 2, 8);
        $ahpService->saveReportAssessment('LPR-TEST', 3, 5);
        
        // Calculate
        $priorities = $ahpService->calculateReportPriorities();
        
        // Assert
        assert(isset($priorities['LPR-TEST']), "Laporan harus ada di hasil");
        assert($priorities['LPR-TEST'] >= 0 && $priorities['LPR-TEST'] <= 1, "Skor harus 0-1");
        
        echo "✓ Test Calculate Report Priorities: PASSED\n";
    }
}
