@extends('layouts.admin')

@section('header_title', 'Edit Pengguna')
@section('header_subtitle', 'Ubah data dan hak akses admin')

@section('header_action')
    <a href="/admin/users" style="text-decoration: none; color: #64748b; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #f1f5f9; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<style>
    .form-container { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03); max-width: 800px;}
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 0.9rem; }
    .form-control {
        width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 8px;
        font-family: 'Montserrat', sans-serif; font-size: 0.95rem; color: #1e293b; transition: all 0.3s;
    }
    .form-control:focus { border-color: #f97316; outline: none; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }
    
    .btn-submit {
        background: var(--primary); color: white; border: none; padding: 0.8rem 2rem;
        border-radius: 8px; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s;
        font-family: 'Montserrat', sans-serif;
    }
    .btn-submit:hover { background: #ea580c; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(249,115,22,0.2); }
    
    .alert-error {
        background: #fee2e2; border-left: 4px solid #ef4444; padding: 1rem; border-radius: 0 8px 8px 0;
        margin-bottom: 1.5rem; color: #b91c1c; font-weight: 600; font-size: 0.9rem;
    }
</style>

<div class="form-container">
    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/admin/users/{{ $user->id }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="username">Username (Untuk Login)</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password (Opsional)</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.4rem;">Isi bagian ini hanya jika Anda ingin mereset password pengguna.</p>
        </div>

        <div class="form-group">
            <label for="role">Role / Hak Akses</label>
            <select id="role" name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="Super Admin" {{ old('role', $user->role) == 'Super Admin' ? 'selected' : '' }}>Sekretaris Desa</option>
                <option value="Kepala Dusun Mlideg" {{ old('role', $user->role) == 'Kepala Dusun Mlideg' ? 'selected' : '' }}>Kepala Dusun Mlideg</option>
                <option value="Kepala Dusun Ngrapah" {{ old('role', $user->role) == 'Kepala Dusun Ngrapah' ? 'selected' : '' }}>Kepala Dusun Ngrapah</option>
            </select>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-submit"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
