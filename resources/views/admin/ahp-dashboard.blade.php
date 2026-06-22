@extends('layouts.admin')

@section('header_title', 'Dashboard AHP')
@section('header_subtitle', 'Sistem Analytic Hierarchy Process untuk menentukan urgensi laporan')

@section('content')
<style>
    .ahp-cards {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;
    }
    .ahp-card {
        background: #fff; border-radius: 16px; padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: transform 0.2s, box-shadow 0.2s;
    }
    .ahp-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
    .ahp-card-icon {
        width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }
    .c-blue { background: #e0f2fe; color: #0ea5e9; }
    .c-orange { background: #ffedd5; color: #f97316; }
    .c-green { background: #dcfce3; color: #22c55e; }
    .c-red { background: #fee2e2; color: #ef4444; }
    .c-purple { background: #f3e8ff; color: #a855f7; }
    .ahp-card-info h3 { font-size: 1.8rem; font-weight: 900; color: #1e293b; line-height: 1.1; margin: 0; }
    .ahp-card-info p { color: #64748b; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; margin: 0.2rem 0 0; letter-spacing: 0.5px; }

    .section-box {
        background: #fff; border-radius: 16px; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 2rem;
    }
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .section-header h3 { font-size: 1.15rem; font-weight: 800; color: #1e293b; margin: 0; }

    .weight-item { margin-bottom: 1.2rem; }
    .weight-item:last-child { margin-bottom: 0; }
    .weight-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .weight-meta strong { font-size: 0.95rem; font-weight: 700; color: #1e293b; }
    .weight-badge {
        padding: 0.25rem 0.7rem; border-radius: 20px; font-size: 0.78rem; font-weight: 700;
        background: #fff7ed; color: #f97316; border: 1px solid #fed7aa;
    }
    .weight-bar { height: 10px; background: #f1f5f9; border-radius: 8px; overflow: hidden; }
    .weight-bar-fill { height: 100%; border-radius: 8px; transition: width 0.6s ease; }
    .wf-dampak { background: linear-gradient(90deg, #f97316, #fb923c); }
    .wf-urgensi { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
    .wf-lama { background: linear-gradient(90deg, #22c55e, #4ade80); }
    .wf-kompleksitas { background: linear-gradient(90deg, #a855f7, #c084fc); }
    .wf-default { background: linear-gradient(90deg, #64748b, #94a3b8); }

    .menu-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; }
    .menu-link {
        display: flex; flex-direction: column; align-items: center; gap: 0.8rem; padding: 1.5rem 1rem;
        background: #f8fafc; border-radius: 14px; text-decoration: none; color: #1e293b;
        transition: all 0.3s; border: 2px solid transparent;
    }
    .menu-link:hover { background: #fff7ed; border-color: #f97316; color: #f97316; transform: translateY(-2px); }
    .menu-link i { font-size: 1.6rem; color: #f97316; }
    .menu-link span { font-size: 0.85rem; font-weight: 700; text-align: center; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: 1rem; background: #f8fafc; color: #475569; font-weight: 700; font-size: 0.85rem; border-bottom: 2px solid #e2e8f0; }
    .data-table td { padding: 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #334155; font-weight: 500; }
    .data-table tbody tr:hover { background: #fefce8; }
    .rank-badge {
        display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 28px;
        padding: 0 8px; border-radius: 8px; font-size: 0.78rem; font-weight: 800;
    }
    .rank-1 { background: #fef2f2; color: #ef4444; }
    .rank-2 { background: #f1f5f9; color: #64748b; }
    .rank-3 { background: #fffbeb; color: #d97706; }
    .rank-default { background: #f0f9ff; color: #0ea5e9; }
    .score-text { font-weight: 800; color: #1e293b; font-size: 1rem; }
    .status-computed {
        padding: 0.25rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
        background: #dcfce3; color: #15803d;
    }

    .alert-custom {
        padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.8rem;
        font-weight: 600; font-size: 0.9rem; animation: slideDown 0.3s ease;
    }
    .alert-success-custom { background: #dcfce3; color: #15803d; border-left: 4px solid #22c55e; }

    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 992px) { .ahp-cards { grid-template-columns: repeat(2, 1fr); } .menu-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .ahp-cards { grid-template-columns: 1fr; } .menu-grid { grid-template-columns: 1fr; } }
</style>

{{-- Alert Messages --}}
@if ($message = Session::get('success'))
    <div class="alert-custom alert-success-custom">
        <i class="fa-solid fa-circle-check"></i> {{ $message }}
    </div>
@endif

{{-- Overview Cards --}}
<div class="ahp-cards">
    <div class="ahp-card">
        <div class="ahp-card-icon c-blue"><i class="fa-solid fa-list-check"></i></div>
        <div class="ahp-card-info">
            <h3>{{ count($criteria) }}</h3>
            <p>Total Kriteria</p>
        </div>
    </div>
    <div class="ahp-card">
        <div class="ahp-card-icon c-orange"><i class="fa-solid fa-scale-balanced"></i></div>
        <div class="ahp-card-info">
            <h3>{{ array_sum((array)$weights) > 0 ? '✓' : '✗' }}</h3>
            <p>{{ array_sum((array)$weights) > 0 ? 'Bobot Terhitung' : 'Belum Dihitung' }}</p>
        </div>
    </div>
    <div class="ahp-card">
        <div class="ahp-card-icon c-green"><i class="fa-solid fa-file-lines"></i></div>
        <div class="ahp-card-info">
            <h3>{{ count($topReports) }}</h3>
            <p>Total Laporan</p>
        </div>
    </div>
    <div class="ahp-card">
        <div class="ahp-card-icon c-red"><i class="fa-solid fa-trophy"></i></div>
        <div class="ahp-card-info">
            @if (isset($topReports[0]))
                <h3>#{{ $topReports[0]['priority_rank'] ?? '-' }}</h3>
                <p>Top Priority</p>
            @else
                <h3>—</h3>
                <p>Belum Ada Data</p>
            @endif
        </div>
    </div>
</div>

{{-- Bobot Kriteria --}}
@if (count($weights) > 0)
    <div class="section-box">
        <div class="section-header">
            <h3><i class="fa-solid fa-chart-pie" style="color: #f97316; margin-right: 0.5rem;"></i>Bobot Kriteria</h3>
        </div>
        @php
            $colorMap = [
                'Dampak' => 'wf-dampak',
                'Urgensi' => 'wf-urgensi',
                'Lama Menunggu' => 'wf-lama',
                'Kompleksitas' => 'wf-kompleksitas',
            ];
        @endphp
        @foreach ($weights as $name => $weight)
            <div class="weight-item">
                <div class="weight-meta">
                    <strong>{{ $name }}</strong>
                    <span class="weight-badge">{{ number_format($weight * 100, 2) }}%</span>
                </div>
                <div class="weight-bar">
                    <div class="weight-bar-fill {{ $colorMap[$name] ?? 'wf-default' }}" style="width: {{ $weight * 100 }}%;"></div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Menu Navigasi AHP --}}
<div class="section-box">
    <div class="section-header">
        <h3><i class="fa-solid fa-compass" style="color: #f97316; margin-right: 0.5rem;"></i>Menu Manajemen AHP</h3>
    </div>
    <div class="menu-grid">
        <a href="/admin/ahp/criteria" class="menu-link">
            <i class="fa-solid fa-list"></i>
            <span>Manajemen Kriteria</span>
        </a>
        <a href="/admin/ahp/pairwise" class="menu-link">
            <i class="fa-solid fa-scale-balanced"></i>
            <span>Perbandingan Kriteria</span>
        </a>
        <a href="/admin/ahp/assessment" class="menu-link">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>Penilaian Laporan</span>
        </a>
        <a href="/admin/ahp/ranking" class="menu-link">
            <i class="fa-solid fa-ranking-star"></i>
            <span>Lihat Ranking</span>
        </a>
    </div>
</div>

{{-- Top Priority Reports --}}
@if (count($topReports) > 0)
    <div class="section-box">
        <div class="section-header">
            <h3><i class="fa-solid fa-fire" style="color: #ef4444; margin-right: 0.5rem;"></i>Top 5 Laporan Prioritas</h3>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Report ID</th>
                        <th>Skor AHP</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topReports as $report)
                        <tr>
                            <td>
                                @if ($report['priority_rank'] == 1)
                                    <span class="rank-badge rank-1">🥇 #1</span>
                                @elseif ($report['priority_rank'] == 2)
                                    <span class="rank-badge rank-2">🥈 #2</span>
                                @elseif ($report['priority_rank'] == 3)
                                    <span class="rank-badge rank-3">🥉 #3</span>
                                @else
                                    <span class="rank-badge rank-default">#{{ $report['priority_rank'] ?? '-' }}</span>
                                @endif
                            </td>
                            <td><strong>{{ $report['report_id'] }}</strong></td>
                            <td><span class="score-text">{{ number_format($report['ahp_score'] ?? 0, 4) }}</span></td>
                            <td><span class="status-computed">Terhitung</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
