<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\Surat;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('role')) return redirect('/login');

        $role = session('role');
        $user = session('user');

        // Statistik Real
        $totalPenduduk = Penduduk::count();
        $pendudukDusun = 0;
        if (str_contains($role, 'Dusun')) {
            $dusunChar = substr($role, -1);
            $pendudukDusun = Penduduk::where('dusun', $dusunChar)->count();
        }

        $pengaduanMenunggu = Pengaduan::where('status', 'Menunggu Validasi')->count();
        $suratAktif = Surat::where('status', 'Menunggu Validasi')->count();

        return view('dashboard', [
            'role' => $role,
            'user' => $user,
            'totalPenduduk' => $totalPenduduk,
            'pendudukDusun' => $pendudukDusun,
            'pengaduanMenunggu' => $pengaduanMenunggu,
            'suratAktif' => $suratAktif
        ]);
    }
}
