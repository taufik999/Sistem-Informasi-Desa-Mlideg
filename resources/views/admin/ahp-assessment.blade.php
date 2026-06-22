@extends('layouts.admin')

@section('header_title', 'Penilaian Laporan AHP')
@section('header_subtitle', 'Berikan skor untuk setiap kriteria laporan warga')

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
    .alert-info-custom { background: #e0f2fe; color: #0369a1; border-left: 4px solid #0ea5e9; }
    .alert-warning-custom {
        background: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem 1.5rem; border-radius: 0 12px 12px 0;
        color: #92400e; font-weight: 600; font-size: 0.9rem; margin-bottom: 1.5rem;
    }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: 0.9rem 1rem; background: #f8fafc; color: #475569; font-weight: 700; font-size: 0.8rem; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; letter-spacing: 0.5px; }
    .data-table td { padding: 0.9rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #334155; font-weight: 500; vertical-align: middle; }
    .data-table tbody tr:hover { background: #fffbeb; }
    .data-table tbody tr { transition: background 0.2s; }

    .badge-kategori { padding: 0.25rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: #e0f2fe; color: #0369a1; }

    .btn-nilai {
        padding: 0.45rem 1rem; background: linear-gradient(135deg, #f97316, #fb923c); color: white;
        border: none; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;
        transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .btn-nilai:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(249,115,22,0.3); }

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

    /* Modal Override */
    .modal-content { border-radius: 16px !important; border: none !important; box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important; }
    .modal-header { border-bottom: 1px solid #f1f5f9 !important; padding: 1.5rem !important; background: linear-gradient(135deg, #f97316, #fb923c) !important; border-radius: 16px 16px 0 0 !important; }
    .modal-header h5 { font-weight: 800 !important; color: white !important; }
    .modal-header .btn-close { filter: brightness(0) invert(1); }
    .modal-body { padding: 1.5rem !important; }
    .modal-footer { border-top: 1px solid #f1f5f9 !important; padding: 1rem 1.5rem !important; }

    .modal-form-group { margin-bottom: 1.2rem; }
    .modal-form-label { display: block; margin-bottom: 0.4rem; font-weight: 700; color: #1e293b; font-size: 0.88rem; }
    .modal-form-desc { font-size: 0.8rem; color: #64748b; font-weight: 500; margin-bottom: 0.4rem; }
    .modal-form-select {
        width: 100%; padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px;
        font-family: 'Montserrat', sans-serif; font-size: 0.88rem; font-weight: 600; color: #1e293b;
        background: #f8fafc; outline: none; cursor: pointer; transition: border-color 0.3s;
    }
    .modal-form-select:focus { border-color: #f97316; background: #fff; }
    .modal-report-info { background: #f8fafc; padding: 0.8rem 1rem; border-radius: 10px; margin-bottom: 1.2rem; }
    .modal-report-info p { margin: 0.3rem 0; font-size: 0.88rem; color: #334155; }
    .modal-report-info strong { color: #1e293b; }

    .modal-btn-close {
        padding: 0.5rem 1.2rem; background: #f1f5f9; color: #64748b; border: none; border-radius: 8px;
        font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .modal-btn-close:hover { background: #e2e8f0; }
    .modal-btn-submit {
        padding: 0.5rem 1.5rem; background: linear-gradient(135deg, #f97316, #fb923c); color: white;
        border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;
        transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .modal-btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(249,115,22,0.3); }

    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 576px) { .data-table { font-size: 0.8rem; } .data-table th, .data-table td { padding: 0.6rem 0.5rem; } }
</style>

{{-- Alert Messages --}}
@if ($message = Session::get('success'))
    <div class="alert-custom alert-success-custom">
        <i class="fa-solid fa-circle-check"></i> {{ $message }}
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert-custom alert-info-custom">
        <i class="fa-solid fa-robot"></i> {{ $message }}
    </div>
@endif

{{-- Check if criteria and weights exist --}}
@if (count($criteria) == 0)
    <div class="alert-warning-custom">
        <i class="fa-solid fa-triangle-exclamation" style="margin-right: 0.4rem;"></i>
        <strong>Belum ada kriteria!</strong>
        Silakan buat kriteria terlebih dahulu di menu <strong>Manajemen Kriteria</strong>.
    </div>
@elseif (count($pengaduan) == 0)
    <div class="alert-warning-custom">
        <i class="fa-solid fa-triangle-exclamation" style="margin-right: 0.4rem;"></i>
        <strong>Belum ada laporan!</strong>
        Warga belum membuat laporan. Periksa kembali nanti.
    </div>
@else
    {{-- Daftar Laporan --}}
    <div class="section-box">
        <div class="section-header">
            <h3><i class="fa-solid fa-clipboard-list" style="color: #f97316; margin-right: 0.5rem;"></i>Penilaian Laporan Terhadap Setiap Kriteria</h3>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Track ID</th>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduan as $p)
                        <tr>
                            <td><strong>{{ $p['track_id'] }}</strong></td>
                            <td>{{ $p['nama'] }}</td>
                            <td><span class="badge-kategori">{{ $p['kategori'] }}</span></td>
                            <td>{{ $p['tanggal'] }}</td>
                            <td>
                                <button type="button" class="btn-nilai" data-bs-toggle="modal" data-bs-target="#assessmentModal{{ $loop->index }}">
                                    <i class="fa-solid fa-pen-to-square" style="margin-right: 0.3rem;"></i> Nilai
                                </button>
                            </td>
                        </tr>

                        {{-- Assessment Modal --}}
                        <div class="modal fade" id="assessmentModal{{ $loop->index }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fa-solid fa-pen-ruler" style="margin-right: 0.5rem;"></i>Nilai Laporan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="/admin/ahp/assessment">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="report_id" value="{{ $p['track_id'] }}">

                                            <div class="modal-report-info">
                                                <p><strong>Track ID:</strong> {{ $p['track_id'] }}</p>
                                                <p><strong>Pelapor:</strong> {{ $p['nama'] }}</p>
                                                <p><strong>Subjek:</strong> {{ $p['subjek'] }}</p>
                                            </div>

                                            @foreach ($criteria as $c)
                                                <div class="modal-form-group">
                                                    <label class="modal-form-label">{{ $c->name }}</label>
                                                    <div class="modal-form-desc">{{ $c->description }}</div>
                                                    <select name="scores[{{ $c->id }}]" class="modal-form-select" required>
                                                        <option value="">Pilih Nilai (1-9)</option>
                                                        @for ($i = 1; $i <= 9; $i++)
                                                            <option value="{{ $i }}">{{ $i }} - {{ match($i) {
                                                                1 => 'Sangat Rendah',
                                                                2 => 'Rendah',
                                                                3 => 'Rendah-Sedang',
                                                                4 => 'Sedang',
                                                                5 => 'Sedang-Tinggi',
                                                                6 => 'Tinggi',
                                                                7 => 'Tinggi',
                                                                8 => 'Sangat Tinggi',
                                                                9 => 'Sangat Tinggi'
                                                            } }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="modal-btn-submit">
                                                <i class="fa-solid fa-floppy-disk" style="margin-right: 0.3rem;"></i> Simpan Penilaian
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Calculate Button --}}
        <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <a href="/admin/ahp/assessment/calculate" class="btn-calculate">
                <i class="fa-solid fa-calculator"></i> Hitung Prioritas Laporan
            </a>
            <span style="color: #94a3b8; font-size: 0.83rem; font-weight: 500;">
                Setelah menilai semua laporan, klik untuk menghitung prioritas.
            </span>
        </div>
    </div>

    {{-- Info Box --}}
    <div class="info-box">
        <strong><i class="fa-solid fa-circle-info" style="margin-right: 0.4rem;"></i>Cara Penilaian:</strong>
        <ol>
            <li>Klik tombol "Nilai" untuk membuka form penilaian laporan</li>
            <li>Berikan skor 1-9 untuk setiap kriteria berdasarkan kondisi laporan</li>
            <li>Skor 1 = sangat rendah, 9 = sangat tinggi</li>
            <li>Setelah menilai semua laporan, klik <strong>"Hitung Prioritas Laporan"</strong></li>
            <li>Sistem akan menghitung skor AHP untuk setiap laporan berdasarkan penilaian dan bobot kriteria</li>
        </ol>
    </div>
@endif

@endsection
