@extends('layouts.admin')

@section('title', 'Pengaturan Beranda')
@section('header_title', 'Pengaturan Beranda')
@section('header_subtitle', 'Sesuaikan konten teks yang akan ditampilkan di halaman utama publik website Desa.')

@section('content')

<div class="card" style="margin-bottom: 2rem;">
    <form action="/admin/beranda/edit" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b;">1. Teks Sambutan (Hero Section)</h3>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #64748b;">Teks besar yang muncul pertama kali di gambar latar.</p>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="hero_title_1" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Teks Pembuka Judul</label>
                <input type="text" name="hero_title_1" id="hero_title_1" value="{{ old('hero_title_1', $hero_title_1) }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                <small style="color: #64748b; margin-top: 0.5rem; display: block;">Contoh: "Selamat Datang di"</small>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="hero_title_highlight" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Teks Judul Utama (Berwarna Orange)</label>
                <input type="text" name="hero_title_highlight" id="hero_title_highlight" value="{{ old('hero_title_highlight', $hero_title_highlight) }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; color: #ea580c; font-weight: bold;">
                <small style="color: #64748b; margin-top: 0.5rem; display: block;">Teks ini akan otomatis ditampilkan di baris baru dengan warna orange. Contoh: "Desa Mlideg"</small>
            </div>
            
            <div class="form-group">
                <label for="hero_subtitle" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Sub-Judul (Deskripsi Singkat)</label>
                <textarea name="hero_subtitle" id="hero_subtitle" rows="3" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-family: inherit;">{{ old('hero_subtitle', $setting->hero_subtitle) }}</textarea>
            </div>
        </div>

        <div class="card-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0; padding: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b;">2. Profil Kepala Desa</h3>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #64748b;">Informasi Kepala Desa dan Pesan Sambutannya.</p>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group" style="display: flex; flex-direction: column; height: 100%;">
                    <label for="sambutan_nama" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Nama Kepala Desa</label>
                    <input type="text" name="sambutan_nama" id="sambutan_nama" value="{{ old('sambutan_nama', $setting->sambutan_nama) }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; margin-top: auto;">
                </div>
                <div class="form-group" style="display: flex; flex-direction: column; height: 100%;">
                    <label for="sambutan_jabatan" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Jabatan</label>
                    <input type="text" name="sambutan_jabatan" id="sambutan_jabatan" value="{{ old('sambutan_jabatan', $setting->sambutan_jabatan) }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; margin-top: auto;">
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="sambutan_foto" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Foto Kepala Desa (Opsional)</label>
                @if($setting->sambutan_foto)
                    <div style="margin-bottom: 1rem; border: 1px dashed #cbd5e1; padding: 0.5rem; border-radius: 8px; display: inline-block;">
                        <img src="{{ asset('storage/' . $setting->sambutan_foto) }}" alt="Preview Foto" style="height: 120px; object-fit: cover; border-radius: 4px;">
                    </div>
                @endif
                <input type="file" name="sambutan_foto" id="sambutan_foto" accept="image/*" style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                <small style="color: #64748b; margin-top: 0.5rem; display: block;">Kosongkan jika tidak ingin mengubah foto saat ini. Format: JPG/PNG.</small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="sambutan_judul" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Judul Sambutan</label>
                <input type="text" name="sambutan_judul" id="sambutan_judul" value="{{ old('sambutan_judul', $setting->sambutan_judul) }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
            </div>

            <div class="form-group">
                <label for="sambutan_konten" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Isi Sambutan</label>
                <textarea name="sambutan_konten" id="sambutan_konten" rows="5" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-family: inherit;">{{ old('sambutan_konten', $setting->sambutan_konten) }}</textarea>
            </div>
        </div>

        <div class="card-footer" style="padding: 1.5rem; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2rem; font-weight: 600; font-size: 1rem;">
                <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
