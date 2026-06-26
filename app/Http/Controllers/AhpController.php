<?php

namespace App\Http\Controllers;

use App\Services\AhpService;
use App\Models\AhpCriteria;
use App\Models\AhpPairwiseComparison;
use App\Models\AhpReportAssessment;
use App\Models\ReportPriority;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class AhpController extends Controller
{
    protected AhpService $ahpService;

    public function __construct(AhpService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    /**
     * Dashboard AHP - menampilkan overview AHP
     */
    public function dashboard()
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $criteria = $this->ahpService->getActiveCriteria();
        $weights = $this->ahpService->getCriteriaWeights();
        $topReports = $this->ahpService->getTopPriorityReports(5);

        return view('admin.ahp-dashboard', [
            'role' => session('role'),
            'user' => session('user'),
            'criteria' => $criteria,
            'weights' => $weights,
            'topReports' => $topReports
        ]);
    }

    /**
     * Halaman manajemen kriteria
     */
    public function manageCriteria()
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $criteria = $this->ahpService->getAllCriteria();

        return view('admin.ahp-criteria', [
            'role' => session('role'),
            'user' => session('user'),
            'criteria' => $criteria
        ]);
    }

    /**
     * Halaman edit kriteria
     */
    public function editCriteria(int $id)
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $criterium = AhpCriteria::findOrFail($id);

        return view('admin.edit-ahp-criteria', [
            'role' => session('role'),
            'user' => session('user'),
            'criterium' => $criterium
        ]);
    }

    /**
     * Simpan/update kriteria
     */
    public function saveCriteria(Request $request)
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'weight' => 'nullable|numeric|min:0|max:100'
        ]);

        $weightToSave = null;
        if ($request->has('weight') && $validated['weight'] !== null) {
            $weightToSave = $validated['weight'] / 100;
        }

        if ($request->has('id') && $request->id) {
            $criteria = AhpCriteria::find($request->id);
            if ($criteria) {
                $criteria->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'order' => $validated['order'] ?? $criteria->order,
                    'is_active' => $request->has('is_active') ? true : false,
                    'weight' => $weightToSave !== null ? $weightToSave : $criteria->weight
                ]);
            }
            $message = 'Kriteria berhasil diperbarui!';
        } else {
            $order = $validated['order'] ?? (AhpCriteria::max('order') + 1);
            AhpCriteria::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? '',
                'order' => $order,
                'is_active' => true,
                'weight' => $weightToSave ?? 0
            ]);
            $message = 'Kriteria berhasil ditambahkan!';
        }

        return redirect('/admin/ahp/criteria')->with('success', $message);
    }

    /**
     * Hapus kriteria
     */
    public function deleteCriteria(int $id)
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        AhpCriteria::where('id', $id)->delete();

        return redirect('/admin/ahp/criteria')->with('success', 'Kriteria berhasil dihapus!');
    }

    /**
     * Halaman perbandingan berpasangan (Pairwise Comparison)
     */
    public function pairwiseComparison()
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $criteria = $this->ahpService->getActiveCriteria();
        $comparisons = [];
        $pairwiseData = AhpPairwiseComparison::all();

        foreach ($criteria as $c1) {
            foreach ($criteria as $c2) {
                if ($c1->id < $c2->id) {
                    $val = 1;
                    foreach ($pairwiseData as $comp) {
                        if ($comp->criteria_1_id == $c1->id && $comp->criteria_2_id == $c2->id) {
                            $val = $comp->comparison_value;
                            break;
                        }
                    }

                    $comparisons[] = [
                        'criteria_1' => $c1,
                        'criteria_2' => $c2,
                        'value' => $val
                    ];
                }
            }
        }

        return view('admin.ahp-pairwise', [
            'role' => session('role'),
            'user' => session('user'),
            'criteria' => $criteria,
            'comparisons' => $comparisons
        ]);
    }

    /**
     * Simpan perbandingan berpasangan
     */
    public function savePairwiseComparison(Request $request)
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'criteria_1_id' => 'required|integer',
            'criteria_2_id' => 'required|integer',
            'value' => 'required|numeric|min:0.1|max:9'
        ]);

        $this->ahpService->savePairwiseComparison(
            $validated['criteria_1_id'],
            $validated['criteria_2_id'],
            $validated['value']
        );

        return redirect('/admin/ahp/pairwise')->with('success', 'Perbandingan berhasil disimpan!');
    }

    /**
     * Hitung ulang bobot kriteria
     */
    public function calculateWeights()
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $result = $this->ahpService->calculateCriteriaWeights();

        if ($result['is_consistent']) {
            $message = 'Bobot berhasil dihitung! (CR: ' . number_format($result['consistency_ratio'], 4) . ' - Konsisten)';
        } else {
            $message = 'Bobot berhasil dihitung, namun CR > 0.1 (Tidak konsisten). Silakan sesuaikan perbandingan!';
        }

        return redirect('/admin/ahp/pairwise')->with('success', $message);
    }

    /**
     * Halaman penilaian laporan
     */
    public function assessmentReports()
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $criteria = collect($this->ahpService->getActiveCriteria());
        $pengaduan = Pengaduan::all();

        // Fitur: Penilaian Otomatis Massal (Auto-Assess All Unassessed Reports)
        $assessedReportIds = AhpReportAssessment::pluck('report_id')->unique()->toArray();
        
        $autoAssessedCount = 0;
        foreach ($pengaduan as $p) {
            if (!in_array($p->track_id, $assessedReportIds)) {
                $this->ahpService->autoAssessReport($p->toArray());
                $autoAssessedCount++;
            }
        }

        $this->ahpService->updateAgingScores($pengaduan->toArray());

        if ($autoAssessedCount > 0) {
            session()->flash('info', $autoAssessedCount . ' laporan telah dinilai secara otomatis oleh sistem kecerdasan AHP!');
        }

        // Convert pengaduan to array to match view expectations
        return view('admin.ahp-assessment', [
            'role' => session('role'),
            'user' => session('user'),
            'criteria' => $criteria,
            'pengaduan' => $pengaduan->toArray()
        ]);
    }

    /**
     * Simpan penilaian laporan
     */
    public function saveAssessment(Request $request)
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'report_id' => 'required|string',
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:1|max:9'
        ]);

        foreach ($validated['scores'] as $criteriaId => $score) {
            $this->ahpService->saveReportAssessment(
                $validated['report_id'],
                $criteriaId,
                $score
            );
        }

        // Hitung ulang AHP
        $this->ahpService->calculateReportPriorities();

        return redirect('/admin/ahp/assessment')->with('success', 'Penilaian untuk semua kriteria berhasil disimpan!');
    }

    /**
     * Hitung prioritas semua laporan
     */
    public function calculatePriorities()
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $this->ahpService->calculateReportPriorities();

        return redirect('/admin/ahp/ranking')->with('success', 'Prioritas laporan berhasil dihitung!');
    }

    /**
     * Tampilkan ranking prioritas laporan
     */
    public function ranking()
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $ranking = $this->ahpService->getReportRanking();
        $pengaduan = Pengaduan::all()->toArray();

        // Match laporan dengan data dari database
        foreach ($ranking as &$report) {
            foreach ($pengaduan as $p) {
                if ($p['track_id'] === $report['report_id']) {
                    $report['laporan_detail'] = $p;
                    break;
                }
            }
        }

        return view('admin.ahp-ranking', [
            'role' => session('role'),
            'user' => session('user'),
            'ranking' => $ranking
        ]);
    }

    /**
     * Inisialisasi kriteria default
     */
    public function initializeDefault()
    {
        if (!session()->has('role')) {
            return redirect('/login');
        }

        $this->ahpService->initializeDefaultCriteria();

        return redirect('/admin/ahp/criteria')->with('success', 'Kriteria default berhasil diinisialisasi!');
    }

    /**
     * Reset semua data AHP
     */
    public function reset()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') {
            return redirect('/dashboard')->with('error', 'Hanya Super Admin yang dapat mereset AHP!');
        }

        $this->ahpService->resetAllAhpData();

        return redirect('/admin/ahp/dashboard')->with('success', 'Semua data AHP berhasil direset!');
    }
}

