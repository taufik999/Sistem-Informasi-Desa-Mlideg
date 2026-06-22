@extends('layouts.admin')

@section('header_title', 'Perbandingan Kriteria AHP')
@section('header_subtitle', 'Pairwise Comparison Matrix')

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

    .scale-table { width: 100%; border-collapse: collapse; margin-bottom: 0.5rem; }
    .scale-table th { text-align: left; padding: 0.7rem 1rem; background: #f8fafc; color: #475569; font-weight: 700; font-size: 0.8rem; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; }
    .scale-table td { padding: 0.55rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem; color: #334155; font-weight: 500; }
    .scale-table td:first-child { font-weight: 800; color: #f97316; width: 80px; text-align: center; }
    .scale-table tbody tr:hover { background: #fffbeb; }

    /* Comparison Grid Layout */
    .comparison-list { display: flex; flex-direction: column; gap: 0; }

    .comparison-row {
        display: grid;
        grid-template-columns: 1fr 40px 90px 1fr auto;
        align-items: center;
        gap: 0.8rem;
        padding: 0.9rem 1.2rem;
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }
    .comparison-row:first-child { border-radius: 12px 12px 0 0; }
    .comparison-row:last-child { border-radius: 0 0 12px 12px; border-bottom: none; }
    .comparison-row:only-child { border-radius: 12px; }
    .comparison-row:nth-child(odd) { background: #fafbfc; }
    .comparison-row:hover { background: #fffbeb; }

    .comp-label-left {
        font-weight: 700; color: #1e293b; font-size: 0.9rem; text-align: right;
        padding-right: 0.3rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .comp-label-right {
        font-weight: 700; color: #1e293b; font-size: 0.9rem; text-align: left;
        padding-left: 0.3rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .comp-vs {
        color: #94a3b8; font-weight: 800; font-size: 0.7rem; text-transform: uppercase;
        text-align: center; letter-spacing: 1px;
    }
    .comp-select {
        width: 100%; padding: 0.5rem 0.5rem; border: 2px solid #e2e8f0; border-radius: 8px;
        font-family: 'Montserrat', sans-serif; font-size: 0.85rem; font-weight: 700;
        color: #1e293b; background: white; outline: none; cursor: pointer;
        transition: border-color 0.3s; text-align: center; appearance: auto;
    }
    .comp-select:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }

    .btn-save-comp {
        padding: 0.45rem 0.9rem; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white;
        border: none; border-radius: 8px; font-weight: 700; font-size: 0.78rem; cursor: pointer;
        transition: all 0.3s; font-family: 'Montserrat', sans-serif; white-space: nowrap;
        display: inline-flex; align-items: center; gap: 0.3rem;
    }
    .btn-save-comp:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(14,165,233,0.3); }

    /* Table header row for comparisons */
    .comparison-header {
        display: grid;
        grid-template-columns: 1fr 40px 90px 1fr auto;
        align-items: center;
        gap: 0.8rem;
        padding: 0.6rem 1.2rem;
        background: #f1f5f9;
        border-radius: 12px 12px 0 0;
        margin-bottom: 0;
    }
    .comparison-header span {
        font-size: 0.72rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .comparison-header span:first-child { text-align: right; }
    .comparison-header span:nth-child(2) { text-align: center; }
    .comparison-header span:nth-child(3) { text-align: center; }
    .comparison-header span:nth-child(4) { text-align: left; }
    .comparison-header span:last-child { text-align: center; }

    .comparison-wrapper {
        border: 2px solid #f1f5f9; border-radius: 14px; overflow: hidden;
    }
    .comparison-wrapper form:last-child .comparison-row { border-bottom: none; }

    .btn-calculate {
        display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.9rem 2rem;
        background: linear-gradient(135deg, #22c55e, #4ade80); color: white; border: none; border-radius: 12px;
        font-weight: 800; font-size: 0.95rem; cursor: pointer; text-decoration: none;
        transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .btn-calculate:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(34,197,94,0.3); color: white; }

    .info-box {
        background: #f0f9ff; border-left: 4px solid #0ea5e9; padding: 1.2rem 1.5rem; border-radius: 0 12px 12px 0;
        font-size: 0.88rem; color: #0c4a6e; line-height: 1.7;
    }
    .info-box strong { color: #0369a1; }
    .info-box ol { margin: 0.5rem 0 0; padding-left: 1.5rem; }
    .info-box li { margin-bottom: 0.3rem; }

    .alert-warning-custom {
        background: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem 1.5rem; border-radius: 0 12px 12px 0;
        color: #92400e; font-weight: 600; font-size: 0.9rem;
    }

    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 768px) {
        .comparison-header { display: none; }
        .comparison-row {
            grid-template-columns: 1fr;
            gap: 0.5rem; padding: 1rem; text-align: center;
        }
        .comp-label-left, .comp-label-right { text-align: center; padding: 0; }
        .comp-vs { display: none; }
        .comp-label-right::before { content: 'vs '; color: #94a3b8; font-size: 0.75rem; }
    }
</style>

{{-- Alert Messages --}}
@if ($message = Session::get('success'))
    <div class="alert-custom alert-success-custom">
        <i class="fa-solid fa-circle-check"></i> {{ $message }}
    </div>
@endif

{{-- Perbandingan Matrix --}}
<div class="section-box">
    <div class="section-header">
        <h3><i class="fa-solid fa-scale-balanced" style="color: #f97316; margin-right: 0.5rem;"></i>Matriks Perbandingan Berpasangan</h3>
    </div>
    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.2rem; font-weight: 500;">
        Berikan nilai perbandingan antar kriteria menggunakan skala 1-9:
    </p>

    {{-- Scale Reference --}}
    <details style="margin-bottom: 1.5rem;">
        <summary style="cursor: pointer; font-weight: 700; color: #0369a1; font-size: 0.88rem; padding: 0.5rem 0; display: inline-flex; align-items: center; gap: 0.4rem;">
            <i class="fa-solid fa-table-cells"></i> Lihat Skala Perbandingan
        </summary>
        <div style="margin-top: 0.8rem;">
            <table class="scale-table">
                <thead>
                    <tr>
                        <th>Nilai</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Kedua kriteria sama penting</td></tr>
                    <tr><td>3</td><td>Kriteria pertama sedikit lebih penting</td></tr>
                    <tr><td>5</td><td>Kriteria pertama lebih penting</td></tr>
                    <tr><td>7</td><td>Kriteria pertama jauh lebih penting</td></tr>
                    <tr><td>9</td><td>Kriteria pertama sangat jauh lebih penting</td></tr>
                    <tr><td>2,4,6,8</td><td>Nilai-nilai tengah (kompromi)</td></tr>
                </tbody>
            </table>
        </div>
    </details>

    {{-- Comparison Forms --}}
    @if (count($comparisons) > 0)
        <div class="comparison-wrapper">
            {{-- Header --}}
            <div class="comparison-header">
                <span>Kriteria 1</span>
                <span></span>
                <span>Nilai</span>
                <span>Kriteria 2</span>
                <span>Aksi</span>
            </div>

            {{-- Rows --}}
            @foreach ($comparisons as $comp)
                <form method="POST" action="/admin/ahp/pairwise">
                    @csrf
                    <div class="comparison-row">
                        <span class="comp-label-left">{{ $comp['criteria_1']->name }}</span>
                        <input type="hidden" name="criteria_1_id" value="{{ $comp['criteria_1']->id }}">

                        <span class="comp-vs">VS</span>

                        <select name="value" class="comp-select" required>
                            @for ($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}" {{ $comp['value'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>

                        <span class="comp-label-right">{{ $comp['criteria_2']->name }}</span>
                        <input type="hidden" name="criteria_2_id" value="{{ $comp['criteria_2']->id }}">

                        <button type="submit" class="btn-save-comp">
                            <i class="fa-solid fa-check"></i> Simpan
                        </button>
                    </div>
                </form>
            @endforeach
        </div>
    @else
        <div class="alert-warning-custom">
            <i class="fa-solid fa-triangle-exclamation" style="margin-right: 0.4rem;"></i>
            <strong>Belum ada kriteria!</strong>
            Silakan tambahkan kriteria terlebih dahulu di menu <strong>Manajemen Kriteria</strong>.
        </div>
    @endif

    {{-- Calculate Button --}}
    @if (count($comparisons) > 0)
        <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <a href="/admin/ahp/pairwise/calculate" class="btn-calculate">
                <i class="fa-solid fa-calculator"></i> Hitung Bobot Kriteria
            </a>
            <span style="color: #94a3b8; font-size: 0.83rem; font-weight: 500;">
                Setelah mengisi semua perbandingan, klik untuk menghitung bobot.
            </span>
        </div>
    @endif
</div>

{{-- Info Box --}}
<div class="info-box">
    <strong><i class="fa-solid fa-circle-info" style="margin-right: 0.4rem;"></i>Cara Kerja:</strong>
    <ol>
        <li>Isikan nilai perbandingan untuk setiap pasang kriteria</li>
        <li>Nilai > 1 berarti kriteria pertama lebih penting</li>
        <li>Klik <strong>"Hitung Bobot Kriteria"</strong> untuk menghitung prioritas setiap kriteria</li>
        <li>Sistem akan mengecek Consistency Ratio (CR) untuk memastikan penilaian konsisten</li>
        <li>CR harus ≤ 0.1 untuk dianggap konsisten</li>
    </ol>
</div>

@endsection
