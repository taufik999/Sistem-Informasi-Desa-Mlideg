<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Services\AhpService;

class PengaduanController extends Controller
{
    // Public
    public function create()
    {
        return view('lapor');
    }

    public function cekPelapor(Request $request)
    {
        $nik = $request->input('nik');
        $nkk = $request->input('nkk');

        if (!$nik || !$nkk) {
            return response()->json(['success' => false]);
        }

        $penduduk = \App\Models\Penduduk::where('nik', $nik)->where('nkk', $nkk)->first();
        if (!$penduduk) {
            return response()->json(['success' => false]);
        }

        $dusun = $penduduk->dusun;
        if (!str_starts_with(strtolower($dusun), 'dusun')) {
            $dusun = 'Dusun ' . $dusun;
        }

        $pengaduan = Pengaduan::where('nik', $nik)->whereNotNull('hp')->latest()->first();
        $hp = $penduduk->no_telp ?? ($pengaduan ? $pengaduan->hp : '');

        return response()->json([
            'success' => true,
            'dusun' => $dusun,
            'hp' => $hp,
            'nama' => $penduduk->nama
        ]);
    }

    public function store(Request $request, AhpService $ahpService)
    {
        $request->validate([
            'nik' => 'required|string',
            'nkk' => 'required|string',
            'hp' => 'required|string',
            'dusun' => 'required|string',
            'kategori' => 'required|string',
            'subjek' => 'required|string',
            'pesan' => 'required|string',
        ]);

        $nik = $request->input('nik');
        $nkk = $request->input('nkk');

        // Validasi NIK dan NKK ke tabel Penduduk
        $penduduk = \App\Models\Penduduk::where('nik', $nik)->where('nkk', $nkk)->first();
        if (!$penduduk) {
            return redirect('/lapor')->with('error', 'Validasi Gagal! Kombinasi NIK dan Nomor KK tidak ditemukan di sistem kependudukan desa.');
        }

        $kategori = $request->input('kategori');
        $prefix = 'LPR-X';
        
        switch ($kategori) {
            case 'Infrastruktur & Jalan':
                $prefix = 'LPR-A';
                break;
            case 'Pelayanan Masyarakat':
                $prefix = 'LPR-B';
                break;
            case 'Kebersihan & Lingkungan':
                $prefix = 'LPR-C';
                break;
            case 'Keamanan & Ketertiban':
                $prefix = 'LPR-D';
                break;
            case 'Aspirasi / Saran':
                $prefix = 'LPR-E';
                break;
        }

        $trackId = $prefix . strtoupper(substr(uniqid(), -6));

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/pengaduan'), $filename);
            $fotoPath = 'pengaduan/' . $filename;
        }

        $pengaduanBaru = Pengaduan::create([
            'track_id' => $trackId,
            'nik' => $nik,
            'tanggal' => date('d M Y'),
            'nama' => $penduduk->nama, // Mengambil nama asli dari database
            'hp' => $request->input('hp'),
            'dusun' => $request->input('dusun'),
            'kategori' => $request->input('kategori'),
            'subjek' => $request->input('subjek'),
            'pesan' => $request->input('pesan'),
            'foto' => $fotoPath,
            'status' => 'Menunggu Validasi',
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent')
        ]);

        // Jalankan Auto-Assessment AHP (Rule-Based)
        $ahpService->autoAssessReport($pengaduanBaru->toArray());

        return redirect('/lapor')->with('success', 'Laporan Anda berhasil dikirim dan akan segera ditindaklanjuti oleh Pemerintah Desa.')->with('track_id', $trackId);
    }

    public function cekLaporan(Request $request)
    {
        $report = null;
        if ($request->has('track_id')) {
            $trackId = strtoupper(trim($request->input('track_id')));
            $report = Pengaduan::where('track_id', $trackId)->first();
            
            if (!$report) {
                return redirect('/cek-laporan')->with('error', 'Kode Laporan tidak ditemukan. Pastikan Anda memasukkan kode yang benar.');
            }
        }

        return view('cek-laporan', ['report' => $report]);
    }

    // Admin
    public function adminIndex(AhpService $ahpService)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $pengaduanData = Pengaduan::orderBy('id', 'desc')->get()->toArray();
        
        // Jalankan Auto-Assessment untuk laporan yang belum dinilai
        $assessedReportIds = \App\Models\AhpReportAssessment::pluck('report_id')->unique()->toArray();
        
        foreach ($pengaduanData as $p) {
            if (!in_array($p['track_id'], $assessedReportIds)) {
                $ahpService->autoAssessReport($p);
            }
        }
        
        // Update skor aging (Lama Menunggu) secara dinamis
        $ahpService->updateAgingScores($pengaduanData);
        
        // Refresh ranking setelah auto-assessment
        $ranking = [];
        try {
            $ranking = $ahpService->getReportRanking();
        } catch (\Exception $e) {
            // Abaikan
        }
        
        // Inject AHP score and rank into pengaduan array
        foreach($pengaduanData as &$p) {
            $p['ahp_score'] = 0;
            $p['ahp_rank'] = 999; // Default if not assessed
            
            foreach($ranking as $r) {
                if ($r['report_id'] === $p['track_id']) {
                    $p['ahp_score'] = $r['ahp_score'] ?? 0;
                    $p['ahp_rank'] = $r['priority_rank'] ?: 999;
                    break;
                }
            }
        }
        
        // Sort array by ahp_rank ascending (1 is highest priority), then by id descending (newest)
        usort($pengaduanData, function($a, $b) {
            if ($a['ahp_rank'] === $b['ahp_rank']) {
                return $b['id'] <=> $a['id'];
            }
            return $a['ahp_rank'] <=> $b['ahp_rank'];
        });

        return view('pengaduan', ['role' => session('role'), 'user' => session('user'), 'pengaduan' => $pengaduanData]);
    }

    public function updateStatus($id, $status)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $pengaduan = Pengaduan::findOrFail($id);
        $userRole = session('role');
        $userName = session('user');
        
        // Cek apakah sudah ada yang menangani
        if ($pengaduan->handled_by && $pengaduan->handled_by !== $userName && $userRole !== 'Super Admin') {
            return redirect('/pengaduan')->with('error', 'Gagal! Laporan ini sedang/sudah ditangani oleh ' . $pengaduan->handled_by);
        }

        $data = ['status' => urldecode($status)];
        
        // Set siapa yang menangani jika belum ada (atau jika Super Admin yang override)
        if (!$pengaduan->handled_by || $userRole === 'Super Admin') {
            $data['handled_by'] = $userName;
        }

        $pengaduan->update($data);
        
        return redirect('/pengaduan')->with('success', 'Status laporan berhasil diperbarui!');
    }
}
