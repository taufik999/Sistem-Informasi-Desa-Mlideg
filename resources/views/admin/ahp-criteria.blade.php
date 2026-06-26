@extends('layouts.admin')

@section('header_title', 'Manajemen Kriteria AHP')
@section('header_subtitle', 'Kelola kriteria dan bobot untuk perhitungan AHP')

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

    .criteria-layout { display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; }

    .form-box { background: #fff; border-radius: 16px; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03); height: fit-content; }
    .form-box h3 { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin: 0 0 1.5rem 0; }
    .form-group { margin-bottom: 1.2rem; }
    .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 700; color: #1e293b; font-size: 0.85rem; }
    .form-input {
        width: 100%; padding: 0.7rem 1rem; border: 2px solid #e2e8f0; border-radius: 10px;
        font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 500; color: #1e293b;
        transition: border-color 0.3s; outline: none; background: #f8fafc;
    }
    .form-input:focus { border-color: #f97316; background: #fff; }
    textarea.form-input { resize: vertical; min-height: 80px; }
    .btn-primary-custom {
        width: 100%; padding: 0.8rem; background: linear-gradient(135deg, #f97316, #fb923c); color: white;
        border: none; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer;
        transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .btn-primary-custom:hover { background: linear-gradient(135deg, #ea580c, #f97316); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(249,115,22,0.3); }

    .btn-init {
        display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.2rem; background: #e0f2fe;
        color: #0369a1; border: none; border-radius: 10px; font-weight: 700; font-size: 0.85rem;
        cursor: pointer; text-decoration: none; transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .btn-init:hover { background: #bae6fd; color: #0369a1; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: 0.9rem 1rem; background: #f8fafc; color: #475569; font-weight: 700; font-size: 0.8rem; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; letter-spacing: 0.5px; }
    .data-table td { padding: 0.9rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #334155; font-weight: 500; vertical-align: middle; }
    .data-table tbody tr:hover { background: #fffbeb; }
    .data-table tbody tr { transition: background 0.2s; }

    .badge-weight { padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
    .badge-weight-active { background: #dcfce3; color: #15803d; }
    .badge-weight-none { background: #f1f5f9; color: #94a3b8; }
    .badge-status { padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
    .badge-active { background: #e0f2fe; color: #0369a1; }
    .badge-inactive { background: #fee2e2; color: #991b1b; }

    .action-btn {
        width: 32px; height: 32px; border-radius: 8px; border: none; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem; transition: all 0.2s; text-decoration: none;
    }
    .action-view { background: #e0f2fe; color: #0369a1; }
    .action-view:hover { background: #bae6fd; }
    .action-edit { background: #fff7ed; color: #f97316; }
    .action-edit:hover { background: #fed7aa; }
    .action-delete { background: #fee2e2; color: #ef4444; }
    .action-delete:hover { background: #fecaca; }

    .info-box {
        background: #f0f9ff; border-left: 4px solid #0ea5e9; padding: 1.2rem 1.5rem; border-radius: 0 12px 12px 0;
        margin-top: 0; font-size: 0.88rem; color: #0c4a6e; line-height: 1.7;
    }
    .info-box strong { color: #0369a1; }
    .info-box ul { margin: 0.5rem 0 0; padding-left: 1.5rem; }
    .info-box li { margin-bottom: 0.3rem; }

    /* Modal Override */
    .modal-content { border-radius: 16px !important; border: none !important; box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important; }
    .modal-header { border-bottom: 1px solid #f1f5f9 !important; padding: 1.5rem !important; }
    .modal-header h5 { font-weight: 800 !important; color: #1e293b !important; }
    .modal-body { padding: 1.5rem !important; }
    .modal-body p { margin-bottom: 0.8rem; font-size: 0.9rem; color: #334155; }
    .modal-body p strong { color: #1e293b; }
    .modal-footer { border-top: 1px solid #f1f5f9 !important; padding: 1rem 1.5rem !important; }
    .modal-btn-close {
        padding: 0.5rem 1.2rem; background: #f1f5f9; color: #64748b; border: none; border-radius: 8px;
        font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .modal-btn-close:hover { background: #e2e8f0; }

    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 992px) { .criteria-layout { grid-template-columns: 1fr; } }
    @media (max-width: 576px) { .data-table { font-size: 0.8rem; } .data-table th, .data-table td { padding: 0.6rem 0.5rem; } }
</style>

{{-- Alert Messages --}}
@if ($message = Session::get('success'))
    <div class="alert-custom alert-success-custom">
        <i class="fa-solid fa-circle-check"></i> {{ $message }}
    </div>
@endif

{{-- Tombol Init Default --}}
<div style="margin-bottom: 1.5rem;">
    <a href="/admin/ahp/criteria/init" class="btn-init">
        <i class="fa-solid fa-rotate-right"></i> Inisialisasi Kriteria Default
    </a>
</div>

<div class="criteria-layout">
    {{-- Form Tambah Kriteria --}}
    <div class="form-box">
        <h3><i class="fa-solid fa-plus-circle" style="color: #f97316; margin-right: 0.4rem;"></i>Tambah Kriteria</h3>
        <form method="POST" action="/admin/ahp/criteria">
            @csrf
            <input type="hidden" name="id" id="criteria_id">

            <div class="form-group">
                <label for="name">Nama Kriteria</label>
                <input type="text" class="form-input" id="name" name="name" placeholder="Contoh: Dampak" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-input" id="description" name="description" placeholder="Jelaskan kriteria ini..."></textarea>
            </div>

            <div class="form-group">
                <label for="order">Urutan</label>
                <input type="number" class="form-input" id="order" name="order" min="1" placeholder="1">
            </div>

            <div class="form-group">
                <label for="weight">Bobot Kriteria (%)</label>
                <input type="number" class="form-input" id="weight" name="weight" step="0.01" min="0" max="100" placeholder="0">
            </div>

            <button type="submit" class="btn-primary-custom">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Kriteria
            </button>
        </form>
    </div>

    {{-- Daftar Kriteria --}}
    <div class="section-box">
        <div class="section-header">
            <h3><i class="fa-solid fa-table-list" style="color: #f97316; margin-right: 0.5rem;"></i>Daftar Kriteria</h3>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Bobot</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($criteria as $index => $c)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $c->name }}</strong></td>
                            <td style="max-width: 200px;">
                                <span style="color: #64748b; font-size: 0.85rem;">{{ Str::limit($c->description, 40) }}</span>
                            </td>
                            <td>
                                @if ($c->weight > 0)
                                    <span class="badge-weight badge-weight-active">{{ number_format($c->weight * 100, 2) }}%</span>
                                @else
                                    <span class="badge-weight badge-weight-none">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($c->is_active)
                                    <span class="badge-status badge-active">Aktif</span>
                                @else
                                    <span class="badge-status badge-inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.4rem;">
                                    <button type="button" class="action-btn action-view" data-bs-toggle="modal" data-bs-target="#detailModal{{ $c->id }}" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <a href="/admin/ahp/criteria/{{ $c->id }}/edit" class="action-btn action-edit" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="/admin/ahp/criteria/{{ $c->id }}/delete" class="action-btn action-delete"
                                       onclick="return confirm('Yakin ingin menghapus kriteria ini?')" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>

                                {{-- Modal Detail --}}
                                <div class="modal fade" id="detailModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="fa-solid fa-circle-info" style="color: #0ea5e9; margin-right: 0.5rem;"></i>Detail Kriteria</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Nama Kriteria:</strong><br>{{ $c->name }}</p>
                                                <p><strong>Deskripsi:</strong><br>{{ $c->description ?: '-' }}</p>
                                                <p><strong>Urutan:</strong><br>{{ $c->order }}</p>
                                                <p><strong>Bobot:</strong><br>
                                                    @if ($c->weight > 0)
                                                        <span class="badge-weight badge-weight-active">{{ number_format($c->weight * 100, 2) }}%</span>
                                                    @else
                                                        <span class="badge-weight badge-weight-none">Belum Dihitung</span>
                                                    @endif
                                                </p>
                                                <p><strong>Status:</strong><br>
                                                    @if ($c->is_active)
                                                        <span class="badge-status badge-active">Aktif</span>
                                                    @else
                                                        <span class="badge-status badge-inactive">Nonaktif</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="modal-btn-close" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem; color: #94a3b8;">
                                <i class="fa-solid fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                Belum ada kriteria. Silakan tambahkan atau inisialisasi default.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Info --}}
<div class="info-box">
    <strong><i class="fa-solid fa-circle-info" style="margin-right: 0.4rem;"></i>Informasi:</strong>
    <ul>
        <li>Kriteria adalah aspek yang akan dievaluasi untuk setiap laporan (contoh: Dampak, Urgensi, Kompleksitas)</li>
        <li>Setelah menambahkan kriteria, lanjutkan ke <strong>Perbandingan Kriteria</strong> untuk menentukan tingkat kepentingan</li>
        <li>Bobot akan dihitung secara otomatis setelah Anda melakukan perbandingan berpasangan</li>
    </ul>
</div>

@endsection
