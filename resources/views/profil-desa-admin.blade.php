@extends('layouts.admin')

@section('title', 'Pengaturan Profil Desa')
@section('header_title', 'Pengaturan Profil Desa')
@section('header_subtitle', 'Sesuaikan konten teks yang akan ditampilkan di halaman Profil Desa publik.')

@section('content')

@if(session('success'))
<div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
    <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
</div>
@endif

<div class="card" style="margin-bottom: 2rem;">
    <form action="/admin/profil/edit" method="POST">
        @csrf

        <div class="card-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b;">1. Kilas Sejarah & Geografis</h3>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #64748b;">Informasi dasar mengenai sejarah dan letak wilayah desa.</p>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="sejarah" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Kilas Sejarah</label>
                <textarea name="sejarah" id="sejarah" rows="4" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-family: inherit;">{{ old('sejarah', $setting->sejarah) }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="geografis" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Kondisi Geografis</label>
                <textarea name="geografis" id="geografis" rows="3" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-family: inherit;">{{ old('geografis', $setting->geografis) }}</textarea>
            </div>
        </div>

        <div class="card-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0; padding: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b;">2. Visi & Misi Desa</h3>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #64748b;">Arah pembangunan dan tujuan yang ingin dicapai desa.</p>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="visi" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Visi Desa</label>
                <textarea name="visi" id="visi" rows="3" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-family: inherit;">{{ old('visi', $setting->visi) }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="misi" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Misi Desa</label>
                <textarea name="misi" id="misi" rows="6" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-family: inherit;">{{ str_replace(['<li>', '</li>'], ['', "\n"], old('misi', $setting->misi)) }}</textarea>
                <small style="color: #64748b; margin-top: 0.5rem; display: block;">Tuliskan setiap poin misi pada baris baru (tekan Enter untuk poin baru).</small>
            </div>
        </div>

        <div class="card-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0; padding: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b;">3. Struktur Organisasi</h3>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #64748b;">Penjelasan singkat terkait struktur pemerintahan desa.</p>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div class="form-group">
                <label for="struktur_organisasi" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Deskripsi Struktur Organisasi</label>
                <textarea name="struktur_organisasi" id="struktur_organisasi" rows="3" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-family: inherit;">{{ old('struktur_organisasi', $setting->struktur_organisasi) }}</textarea>
            </div>
        </div>

        <div class="card-footer" style="padding: 1.5rem; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2rem; font-weight: 600; font-size: 1rem; background-color: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; transition: background-color 0.3s;">
                <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
