@extends('layouts.admin')

@section('header_title', 'Ranking Prioritas Laporan')
@section('header_subtitle', 'Urutan laporan berdasarkan urgensi penanganan (AHP)')

@section('header_action')
    <a href="/admin/ahp" style="text-decoration: none; color: #64748b; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #f1f5f9; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<style>
    .section-box {
        background: #fff; border-radius: 16px; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 2rem;
    }
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .section-header h3 { font-size: 1.15rem; font-weight: 800; color: #1e293b; margin: 0; }

    .alert-custom {
        padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.8rem;
        font-weight: 600; font-size: 0.9rem; animation: slideDown 0.3s ease;
    }
    .alert-success-custom { background: #dcfce3; color: #15803d; border-left: 4px solid #22c55e; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: 0.9rem 1rem; background: #f8fafc; color: #475569; font-weight: 700; font-size: 0.8rem; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; letter-spacing: 0.5px; }
    .data-table td { padding: 0.9rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #334155; font-weight: 500; vertical-align: middle; }
    .data-table tbody tr:hover { background: #fffbeb; }
    .data-table tbody tr { transition: background 0.2s; }

    .rank-badge {
        display: inline-flex; align-items: center; justify-content: center; min-width: 48px; height: 32px;
        padding: 0 10px; border-radius: 8px; font-size: 0.85rem; font-weight: 800;
    }
    .rank-1 { background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #ef4444; border: 1px solid #fecaca; }
    .rank-2 { background: linear-gradient(135deg, #f8fafc, #f1f5f9); color: #64748b; border: 1px solid #e2e8f0; }
    .rank-3 { background: linear-gradient(135deg, #fffbeb, #fef3c7); color: #d97706; border: 1px solid #fde68a; }
    .rank-default { background: #f0f9ff; color: #0ea5e9; border: 1px solid #bae6fd; }

    .badge-kategori { padding: 0.25rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: #e0f2fe; color: #0369a1; }

    .score-text { font-weight: 900; color: #1e293b; font-size: 1.05rem; }

    .score-bar-container { width: 100%; min-width: 120px; }
    .score-bar { height: 10px; background: #f1f5f9; border-radius: 8px; overflow: hidden; }
    .score-bar-fill { height: 100%; border-radius: 8px; transition: width 0.6s ease; }
    .score-bar-fill.high { background: linear-gradient(90deg, #ef4444, #f87171); }
    .score-bar-fill.medium { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .score-bar-fill.low { background: linear-gradient(90deg, #22c55e, #4ade80); }
    .score-bar-text { font-size: 0.75rem; font-weight: 600; color: #94a3b8; margin-top: 0.2rem; }

    .status-computed {
        padding: 0.25rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
        background: #dcfce3; color: #15803d;
    }

    .summary-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2rem; }
    .summary-card {
        background: #f8fafc; border-radius: 14px; padding: 1.5rem; text-align: center;
        border: 2px solid #f1f5f9; transition: all 0.2s;
    }
    .summary-card:hover { border-color: #fed7aa; background: #fffbeb; }
    .summary-card h4 { font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.5rem; }
    .summary-card h2 { font-size: 1.6rem; font-weight: 900; color: #1e293b; margin: 0 0 0.3rem; }
    .summary-card p { font-size: 0.8rem; color: #94a3b8; font-weight: 500; margin: 0; }

    .alert-warning-custom {
        background: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem 1.5rem; border-radius: 0 12px 12px 0;
        color: #92400e; font-weight: 600; font-size: 0.9rem;
    }

    .info-box {
        background: #f0f9ff; border-left: 4px solid #0ea5e9; padding: 1.2rem 1.5rem; border-radius: 0 12px 12px 0;
        font-size: 0.88rem; color: #0c4a6e; line-height: 1.7;
    }
    .info-box strong { color: #0369a1; }
    .info-box ul { margin: 0.5rem 0 0; padding-left: 1.5rem; }
    .info-box li { margin-bottom: 0.3rem; }
    .info-box code { background: #e0f2fe; padding: 0.2rem 0.6rem; border-radius: 6px; font-size: 0.85rem; color: #0369a1; font-weight: 600; }

    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 768px) { .summary-cards { grid-template-columns: 1fr; } }
    @media (max-width: 576px) { .data-table { font-size: 0.8rem; } .data-table th, .data-table td { padding: 0.6rem 0.5rem; } }
</style>

{{-- Alert Messages --}}
@if ($message = Session::get('success'))
    <div class="alert-custom alert-success-custom">
        <i class="fa-solid fa-circle-check"></i> {{ $message }}
    </div>
@endif

{{-- Ranking Table --}}
<div class="section-box">
    <div class="section-header">
        <h3><i class="fa-solid fa-ranking-star" style="color: #ef4444; margin-right: 0.5rem;"></i>Prioritas Laporan Berdasarkan Metode AHP</h3>
    </div>

    @if (count($ranking) > 0)
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Rank</th>
                        <th>Report ID</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th style="width: 100px;">Skor AHP</th>
                        <th style="width: 160px;">Visualisasi</th>
                        <th style="width: 80px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ranking as $report)
                        <tr>
                            <td>
                                @if ($report['priority_rank'] == 1)
                                    <span class="rank-badge rank-1">🥇 #1</span>
                                @elseif ($report['priority_rank'] == 2)
                                    <span class="rank-badge rank-2">🥈 #2</span>
                                @elseif ($report['priority_rank'] == 3)
                                    <span class="rank-badge rank-3">🥉 #3</span>
                                @else
                                    <span class="rank-badge rank-default">#{{ $report['priority_rank'] }}</span>
                                @endif
                            </td>
                            <td><strong>{{ $report['report_id'] }}</strong></td>
                            <td>
                                @if (isset($report['laporan_detail']))
                                    {{ $report['laporan_detail']['nama'] }}
                                @else
                                    <span style="color: #94a3b8;">—</span>
                                @endif
                            </td>
                            <td>
                                @if (isset($report['laporan_detail']))
                                    <span class="badge-kategori">{{ $report['laporan_detail']['kategori'] }}</span>
                                @else
                                    <span style="color: #94a3b8;">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="score-text">{{ number_format($report['ahp_score'] ?? 0, 2) }}</span>
                            </td>
                            <td>
                                @php
                                    $scorePercent = ($report['ahp_score'] ?? 0);
                                    $barClass = $scorePercent >= 70 ? 'high' : ($scorePercent >= 40 ? 'medium' : 'low');
                                @endphp
                                <div class="score-bar-container">
                                    <div class="score-bar">
                                        <div class="score-bar-fill {{ $barClass }}" style="width: {{ min(100, $scorePercent) }}%;"></div>
                                    </div>
                                    <div class="score-bar-text">{{ number_format($scorePercent, 1) }}%</div>
                                </div>
                            </td>
                            <td>
                                <span class="status-computed">Terhitung</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Summary Stats --}}
        <div class="summary-cards">
            <div class="summary-card">
                <h4>Total Laporan</h4>
                <h2>{{ count($ranking) }}</h2>
                <p>Laporan dinilai</p>
            </div>
            <div class="summary-card">
                <h4>Prioritas Tertinggi</h4>
                <h2 style="color: #ef4444;">{{ $ranking[0]['report_id'] ?? '-' }}</h2>
                <p>Skor: {{ number_format($ranking[0]['ahp_score'] ?? 0, 4) }}</p>
            </div>
            <div class="summary-card">
                <h4>Prioritas Terendah</h4>
                @php $lastReport = end($ranking); @endphp
                <h2 style="color: #0ea5e9;">{{ $lastReport['report_id'] ?? '-' }}</h2>
                <p>Skor: {{ number_format($lastReport['ahp_score'] ?? 0, 4) }}</p>
            </div>
        </div>
    @else
        <div class="alert-warning-custom">
            <i class="fa-solid fa-triangle-exclamation" style="margin-right: 0.4rem;"></i>
            <strong>Belum ada hasil perhitungan!</strong><br>
            Silakan lakukan penilaian laporan terlebih dahulu, kemudian klik tombol "Hitung Prioritas Laporan"
            di halaman <strong>Penilaian Laporan</strong>.
        </div>
    @endif
</div>

{{-- Penjelasan AHP --}}
<div class="info-box">
    <strong><i class="fa-solid fa-circle-info" style="margin-right: 0.4rem;"></i>Penjelasan Hasil:</strong>
    <ul>
        <li><strong>Rank:</strong> Urutan prioritas laporan yang perlu ditangani (1 = paling urgent)</li>
        <li><strong>Report ID:</strong> Nomor tracking laporan warga</li>
        <li><strong>Skor AHP:</strong> Nilai hasil perhitungan AHP (semakin tinggi semakin urgent)</li>
        <li><strong>Visualisasi:</strong> Grafik persentase skor relatif terhadap maksimum</li>
    </ul>

    <strong style="display: block; margin-top: 0.8rem;">Metode Penghitungan:</strong>
    <p style="margin: 0.3rem 0;">Skor AHP dihitung dengan formula: <code>Skor AHP = Σ (Nilai Kriteria × Bobot Kriteria)</code></p>
    <p style="margin: 0;">Laporan dengan skor tertinggi adalah yang paling mendesak untuk ditangani terlebih dahulu.</p>
</div>

@endsection
