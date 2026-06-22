@extends('layouts.admin')

@section('header_title', 'Daftar Kartu Keluarga (KK)')
@section('header_subtitle', 'Manajemen Data Kartu Keluarga Penduduk Desa Mlideg')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Data Kartu Keluarga</h5>
            <a href="/admin/kk/tambah" class="btn btn-primary btn-sm fw-bold">
                <i class="fa-solid fa-plus"></i> Tambah KK Baru
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="min-width: 800px;">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">No. KK (NKK)</th>
                            <th width="30%">Kepala Keluarga</th>
                            <th width="15%">Jumlah Anggota</th>
                            <th width="20%">Alamat</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kks as $index => $kk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-secondary">{{ $kk->nkk }}</span></td>
                                <td class="fw-bold">{{ $kk->kepala_keluarga }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $kk->jumlah_anggota }} Orang</span>
                                </td>
                                <td>{{ $kk->alamat }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/admin/kk/{{ $kk->nkk }}" class="btn btn-sm btn-info text-white" title="Lihat Anggota Keluarga">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="/admin/kk/{{ $kk->nkk }}/edit" class="btn btn-sm btn-warning text-dark" title="Edit KK">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="/admin/kk/{{ $kk->nkk }}/delete" class="btn btn-sm btn-danger" title="Hapus KK" onclick="return confirm('Peringatan: Menghapus KK ini juga akan menghapus SELURUH data anggota keluarga ({{ $kk->jumlah_anggota }} orang) di dalamnya dari database penduduk! Apakah Anda sangat yakin?')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data Kartu Keluarga</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
