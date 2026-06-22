<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PotensiController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AhpController;
use App\Http\Controllers\StatistikController;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Models\Berita;

Route::get('/', function () {
    $latestBerita = Berita::where('status', 'Published')->orderBy('id', 'desc')->take(3)->get();
    
    $totalPenduduk = \App\Models\Penduduk::count();
    $totalKK = \App\Models\Penduduk::distinct('nkk')->count('nkk');
    $wilayahDusun = 2; // Data dusun sementara hardcode 2
    $rukunTetangga = 16; // Data RT belum ada di skema database, menggunakan data default
    
    // Ambil setting beranda, jika kosong buat default (hanya in-memory atau create jika di DB)
    $homepageSetting = \App\Models\HomepageSetting::first();
    if (!$homepageSetting) {
        $homepageSetting = (object) [
            'hero_title' => 'Selamat Datang di <br> <span class="text-orange">Desa Mlideg</span>',
            'hero_subtitle' => 'Mewujudkan tata kelola desa yang transparan, mandiri, dan berdaya saing melalui digitalisasi pelayanan publik.',
            'sambutan_nama' => 'Erry Cahyono, S.H',
            'sambutan_jabatan' => 'Kepala Desa Mlideg',
            'sambutan_judul' => 'Membangun Desa Bersama Berbasis Digital',
            'sambutan_konten' => '"Assalamu\'alaikum Warahmatullahi Wabarakatuh. Puji syukur ke hadirat Tuhan YME atas peluncuran website profil Desa Mlideg. Kami berkomitmen untuk terus meningkatkan pelayanan publik melalui digitalisasi. Website ini merupakan wujud transparansi dan inovasi kami untuk memudahkan warga mengakses informasi dan layanan administrasi tanpa batas ruang dan waktu."'
        ];
    }
    
    return view('welcome', [
        'berita' => $latestBerita,
        'totalPenduduk' => $totalPenduduk,
        'totalKK' => $totalKK,
        'wilayahDusun' => $wilayahDusun,
        'rukunTetangga' => $rukunTetangga,
        'setting' => $homepageSetting
    ]);
});

Route::get('/profil', function () { 
    $profil = \App\Models\ProfileSetting::first();
    if (!$profil) {
        $profil = (object) [
            'sejarah' => 'Desa Mlideg memiliki sejarah panjang yang berakar dari masa babat alas tanah Jawa Timur. Nama "Mlideg" konon berasal dari kata lokal yang merujuk pada keteguhan hati para pendahulu dalam membangun pemukiman yang subur.',
            'geografis' => 'Berada di dataran subur Kabupaten Bojonegoro, Desa Mlideg berbatasan langsung dengan hamparan persawahan hijau. Desa ini terbagi menjadi beberapa Dusun strategis.',
            'visi' => '"Mewujudkan Desa Mlideg menjadi desa yang maju dalam segi pembangunan fisik, pelayanan masyarakat, pertanian, ekonomi kreatif, dan APBDes Pro Rakyat."',
            'misi' => '<li>Maju dalam segi pembangunan fisik diwujudkan dengan menentukan kebijakan yang mendorong perkembangan pembangunan infrastruktur publik berbasis Ilmu Pengetahuan dan Teknologi (IPTEK)</li><li>Maju dalam segi pelayanan masyarakat diwujudkan dengan digitalisasi layanan, sistem jemput bola, pusat layanan terpadu, peningkatan SDM perangkat desa dan Lembaga Desa, serta aduan terbuka dan transparansi publik.</li><li>Maju dalam segi pertanian diwujudkan dengan pembangunan jalan usaha tani, penguatan irigasi, bantuan alat pertanian, pelatihan petani, serta dukungan bibit dan akses permodalan.</li><li>Maju dalam segi ekonomi kreatif diwujudkan dengan pelatihan UMKM, pengembangan produk lokal, pemasaran digital, pembentukan sentra kreatif, serta dukungan modal dan kemitraan usaha.</li><li>Maju dalam segi APBDesa Pro Rakyat diwujudkan dengan penyusunan partisipatif, alokasi anggaran berpihak pada kepentingan masyarakat, transparansi pengelolaan, serta efisiensi dan pemerataan pembangunan.</li>',
            'struktur_organisasi' => 'Pemerintahan Desa Mlideg dipimpin oleh Kepala Desa, dibantu oleh Sekretaris Desa, para Kepala Urusan (Kaur), Kepala Seksi (Kasi), dan para Kepala Dusun (Kasun) yang bersinergi melayani masyarakat.'
        ];
    }
    return view('profil', ['profil' => $profil]); 
});
Route::get('/struktur', function () { 
    $perangkat = \App\Models\PerangkatDesa::orderBy('level')->orderBy('urutan')->get();
    return view('struktur', compact('perangkat')); 
});
Route::get('/statistik', [StatistikController::class, 'index']);
Route::get('/kontak', function () { return view('kontak'); });

// Berita
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/{id}', [BeritaController::class, 'show']);

// Potensi & Galeri
Route::get('/potensi', [PotensiController::class, 'index']);
Route::get('/galeri', [GaleriController::class, 'index']);

// Pengaduan
Route::get('/lapor', [PengaduanController::class, 'create']);
Route::post('/lapor', [PengaduanController::class, 'store']);
Route::get('/cek-laporan', [PengaduanController::class, 'cekLaporan']);

// Surat
Route::get('/ajuan-surat', [SuratController::class, 'create']);
Route::post('/ajuan-surat', [SuratController::class, 'store']);
Route::get('/cek-surat', [SuratController::class, 'cekSurat']);

// API untuk auto-fill
Route::get('/api/cek-pelapor', [PengaduanController::class, 'cekPelapor']);
Route::get('/api/cek-nik', [\App\Http\Controllers\PendudukController::class, 'cekNik']);

// Authentication (Dummy for now)
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    $user = \App\Models\User::where('username', $username)->first();

    if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
        session(['role' => $user->role, 'user' => $user->name, 'user_id' => $user->id]);
        return redirect('/dashboard');
    }
    
    return back()->with('error', 'Username atau password salah.');
});
Route::get('/logout', function () {
    session()->forget(['role', 'user']);
    return redirect('/login');
});

// Admin Dashboard & Penduduk
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/penduduk', [PendudukController::class, 'index']);
Route::get('/penduduk/tambah', [PendudukController::class, 'create']);
Route::post('/penduduk/tambah', [PendudukController::class, 'store']);
Route::get('/penduduk/export', function () {
    // keeping export as is for now or move to controller if preferred
    if (!session()->has('role')) return redirect('/login');
    $headers = array(
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=data_penduduk_mlideg.csv",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    );
    $callback = function() {
        $file = fopen('php://output', 'w');
        fputcsv($file, array('No', 'NIK', 'Nama Lengkap', 'Dusun', 'Pekerjaan', 'Status'));
        $penduduks = \App\Models\Penduduk::all();
        foreach($penduduks as $index => $p) {
            fputcsv($file, array($index+1, $p->nik, $p->nama, 'Dusun ' . $p->dusun, $p->pekerjaan, $p->status));
        }
        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
});
Route::get('/penduduk/{id}', [PendudukController::class, 'show']);
Route::get('/penduduk/{id}/edit', [PendudukController::class, 'edit']);
Route::post('/penduduk/{id}/edit', [PendudukController::class, 'update']);
Route::get('/penduduk/{id}/delete', [PendudukController::class, 'destroy']);


// Admin Modules
Route::get('/pengaduan', [PengaduanController::class, 'adminIndex']);
Route::get('/pengaduan/{id}/status/{status}', [PengaduanController::class, 'updateStatus']);

Route::get('/admin/berita', [BeritaController::class, 'adminIndex']);
Route::get('/admin/berita/tambah', [BeritaController::class, 'create']);
Route::post('/admin/berita/tambah', [BeritaController::class, 'store']);
Route::get('/admin/berita/{id}', [BeritaController::class, 'adminShow']);
Route::get('/admin/berita/{id}/edit', [BeritaController::class, 'edit']);
Route::post('/admin/berita/{id}/edit', [BeritaController::class, 'update']);
Route::get('/admin/berita/{id}/delete', [BeritaController::class, 'destroy']);

use App\Http\Controllers\PerangkatDesaController;
Route::get('/admin/perangkat', [PerangkatDesaController::class, 'adminIndex']);
Route::get('/admin/perangkat/tambah', [PerangkatDesaController::class, 'create']);
Route::post('/admin/perangkat/tambah', [PerangkatDesaController::class, 'store']);
Route::get('/admin/perangkat/{id}', [PerangkatDesaController::class, 'show']);
Route::get('/admin/perangkat/{id}/edit', [PerangkatDesaController::class, 'edit']);
Route::post('/admin/perangkat/{id}/edit', [PerangkatDesaController::class, 'update']);
Route::get('/admin/perangkat/{id}/delete', [PerangkatDesaController::class, 'destroy']);

Route::get('/admin/galeri', [GaleriController::class, 'adminIndex']);
Route::post('/admin/galeri/tambah', [GaleriController::class, 'store']);
Route::get('/admin/galeri/{id}/delete', [GaleriController::class, 'destroy']);

Route::get('/admin/potensi', [PotensiController::class, 'adminIndex']);
Route::post('/admin/potensi/tambah', [PotensiController::class, 'store']);
Route::get('/admin/potensi/{id}/delete', [PotensiController::class, 'destroy']);

Route::get('/admin/surat', [SuratController::class, 'adminIndex']);
Route::get('/admin/surat/{id}/status/{status}', [SuratController::class, 'updateStatus']);

// KK Routes
Route::get('/admin/kk', [\App\Http\Controllers\PendudukController::class, 'daftarKk'])->name('kk.admin');
Route::get('/admin/kk/tambah', [\App\Http\Controllers\PendudukController::class, 'createKk'])->name('kk.create');
Route::get('/admin/kk/{nkk}/edit', [\App\Http\Controllers\PendudukController::class, 'editKk'])->name('kk.edit');
Route::post('/admin/kk/{nkk}/edit', [\App\Http\Controllers\PendudukController::class, 'updateKk'])->name('kk.update');
Route::get('/admin/kk/{nkk}/delete', [\App\Http\Controllers\PendudukController::class, 'destroyKk'])->name('kk.delete');
Route::get('/admin/kk/{nkk}', [\App\Http\Controllers\PendudukController::class, 'detailKk'])->name('kk.detail');

// Beranda Admin
use App\Http\Controllers\HomepageSettingController;
Route::get('/admin/beranda', [HomepageSettingController::class, 'edit']);
Route::post('/admin/beranda/edit', [HomepageSettingController::class, 'update']);

// Profil Admin
use App\Http\Controllers\ProfileSettingController;
Route::get('/admin/profil', [ProfileSettingController::class, 'edit']);
Route::post('/admin/profil/edit', [ProfileSettingController::class, 'update']);

// AHP Routes

Route::get('/admin/ahp', [AhpController::class, 'dashboard'])->name('ahp.dashboard');
Route::get('/admin/ahp/criteria', [AhpController::class, 'manageCriteria'])->name('ahp.criteria');
Route::post('/admin/ahp/criteria', [AhpController::class, 'saveCriteria'])->name('ahp.criteria.save');
Route::get('/admin/ahp/criteria/{id}/edit', [AhpController::class, 'editCriteria'])->name('ahp.criteria.edit');
Route::get('/admin/ahp/criteria/{id}/delete', [AhpController::class, 'deleteCriteria'])->name('ahp.criteria.delete');
Route::get('/admin/ahp/criteria/init', [AhpController::class, 'initializeDefault'])->name('ahp.criteria.init');
Route::get('/admin/ahp/pairwise', [AhpController::class, 'pairwiseComparison'])->name('ahp.pairwise');
Route::post('/admin/ahp/pairwise', [AhpController::class, 'savePairwiseComparison'])->name('ahp.pairwise.save');
Route::get('/admin/ahp/pairwise/calculate', [AhpController::class, 'calculateWeights'])->name('ahp.calculate');
Route::get('/admin/ahp/assessment', [AhpController::class, 'assessmentReports'])->name('ahp.assessment');
Route::post('/admin/ahp/assessment', [AhpController::class, 'saveAssessment'])->name('ahp.assessment.save');
Route::get('/admin/ahp/assessment/calculate', [AhpController::class, 'calculatePriorities'])->name('ahp.assessment.calculate');
Route::get('/admin/ahp/ranking', [AhpController::class, 'ranking'])->name('ahp.ranking');
Route::get('/admin/ahp/reset', [AhpController::class, 'reset'])->name('ahp.reset');

// User Management Routes
use App\Http\Controllers\UserController;
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admin/users/tambah', [UserController::class, 'create'])->name('users.create');
Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/admin/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::get('/admin/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
