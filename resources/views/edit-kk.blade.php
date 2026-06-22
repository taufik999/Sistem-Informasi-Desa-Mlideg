@extends('layouts.admin')

@section('header_title', 'Edit Kartu Keluarga')
@section('header_subtitle', 'Edit NKK dan Alamat secara massal untuk seluruh anggota keluarga')

@section('header_action')
    <a href="/admin/kk" class="btn btn-secondary">← Batal & Kembali</a>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-pen-to-square text-primary me-2"></i> Form Edit Kartu Keluarga</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-triangle-exclamation"></i> <strong>Perhatian:</strong> Perubahan pada form ini akan diterapkan pada <strong>semua anggota keluarga</strong> yang tergabung dalam NKK ini.
                    </div>

                    <form action="/admin/kk/{{ $nkk }}/edit" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nkk" class="form-label fw-bold">Nomor KK (NKK)</label>
                            <input type="text" class="form-control" id="nkk" name="nkk" value="{{ $nkk }}" required maxlength="16" pattern="\d{16}" title="NKK harus berupa 16 digit angka">
                        </div>
                        
                        <div class="mb-4">
                            <label for="alamat" class="form-label fw-bold">Alamat Keluarga</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $kepala->alamat }}</textarea>
                            <div class="form-text">Alamat ini akan disamakan untuk seluruh anggota keluarga.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="/admin/kk" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
