@extends('layouts.admin')

@section('header_title', 'Detail Kartu Keluarga')
@section('header_subtitle', 'NKK: ' . $nkk)

@section('header_action')
    <a href="/admin/kk" class="btn btn-secondary">← Kembali ke Daftar KK</a>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-users-rectangle me-2"></i>Informasi Keluarga</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Nomor KK</div>
                <div class="col-md-9 fw-bold fs-5">{{ $nkk }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Kepala Keluarga</div>
                <div class="col-md-9 fw-bold">{{ $kepala ? $kepala->nama : '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Alamat</div>
                <div class="col-md-9">{{ $kepala ? $kepala->alamat : '-' }}</div>
            </div>
            <div class="row">
                <div class="col-md-3 text-muted">Jumlah Anggota</div>
                <div class="col-md-9"><span class="badge bg-info text-dark">{{ count($anggota) }} Orang</span></div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Daftar Anggota Keluarga</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat, Tgl Lahir</th>
                            <th>Pendidikan</th>
                            <th>Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $index => $a)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-secondary">{{ $a->nik }}</span></td>
                                <td class="fw-bold">{{ $a->nama }}</td>
                                <td>{{ $a->jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                                <td>{{ $a->tempat_lahir }}, {{ $a->tgl_lahir }}</td>
                                <td>{{ $a->pendidikan }}</td>
                                <td>{{ $a->pekerjaan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Tidak ada data anggota</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
