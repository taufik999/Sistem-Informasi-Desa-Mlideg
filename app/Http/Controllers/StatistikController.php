<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Penduduk;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        $totalPenduduk = Penduduk::count();
        $totalKK = Penduduk::where('hubungan_keluarga', 'Kepala Keluarga')->count();

        // Gender
        $genderData = [
            'L' => Penduduk::where('jk', 'L')->count(),
            'P' => Penduduk::where('jk', 'P')->count()
        ];

        // Education - mapping to simpler categories if needed, but let's take raw first
        $eduRaw = Penduduk::selectRaw('pendidikan, count(*) as total')
            ->groupBy('pendidikan')
            ->pluck('total', 'pendidikan')
            ->toArray();

        // Job - top 5
        $jobRaw = Penduduk::selectRaw('pekerjaan, count(*) as total')
            ->groupBy('pekerjaan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->pluck('total', 'pekerjaan')
            ->toArray();

        // Age Groups
        $ageGroups = [
            '0-14' => Penduduk::whereRaw("TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 0 AND 14")->count(),
            '15-24' => Penduduk::whereRaw("TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 15 AND 24")->count(),
            '25-44' => Penduduk::whereRaw("TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 25 AND 44")->count(),
            '45-64' => Penduduk::whereRaw("TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 45 AND 64")->count(),
            '65+' => Penduduk::whereRaw("TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 65")->count(),
        ];

        // Ratios for Cards
        $sarjanaTotal = Penduduk::whereIn('pendidikan', ['S1', 'S1/D4', 'S2/S3', 'Sarjana (S1+)'])->count();
        $eduRatio = $totalPenduduk > 0 ? round(($sarjanaTotal / $totalPenduduk) * 100, 1) : 0;

        $mayoritasJobName = count($jobRaw) > 0 ? strtoupper(array_keys($jobRaw)[0]) : 'BELUM ADA DATA';
        $mayoritasJobCount = count($jobRaw) > 0 ? array_values($jobRaw)[0] : 0;
        $mayoritasJobRatio = $totalPenduduk > 0 ? round(($mayoritasJobCount / $totalPenduduk) * 100, 1) : 0;

        return view('statistik', [
            'totalPenduduk' => $totalPenduduk,
            'totalKK' => $totalKK,
            'genderData' => $genderData,
            'eduData' => $eduRaw,
            'jobData' => $jobRaw,
            'ageGroups' => $ageGroups,
            'eduRatio' => $eduRatio,
            'mayoritasJobName' => $mayoritasJobName,
            'mayoritasJobRatio' => $mayoritasJobRatio
        ]);
    }
}
