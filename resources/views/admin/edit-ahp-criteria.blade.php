@extends('layouts.admin')

@section('header_title', 'Edit Kriteria AHP')
@section('header_subtitle', 'Ubah data kriteria')

@section('header_action')
    <a href="/admin/ahp/criteria" style="text-decoration: none; color: #64748b; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #f1f5f9; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<style>
    .form-container {
        max-width: 560px; margin: 0 auto;
    }
    .form-box {
        background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .form-box-header {
        display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.8rem;
        padding-bottom: 1rem; border-bottom: 2px solid #f1f5f9;
    }
    .form-box-header i { font-size: 1.3rem; color: #f97316; }
    .form-box-header h3 { font-size: 1.15rem; font-weight: 800; color: #1e293b; margin: 0; }

    .form-group { margin-bottom: 1.4rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: #1e293b; font-size: 0.88rem; }
    .form-input {
        width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 10px;
        font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 500; color: #1e293b;
        transition: border-color 0.3s; outline: none; background: #f8fafc;
    }
    .form-input:focus { border-color: #f97316; background: #fff; }
    textarea.form-input { resize: vertical; min-height: 100px; }

    .switch-group { display: flex; align-items: center; gap: 0.8rem; padding: 1rem; background: #f8fafc; border-radius: 10px; }
    .switch-toggle {
        position: relative; width: 48px; height: 26px; background: #cbd5e1; border-radius: 13px;
        cursor: pointer; transition: background 0.3s; flex-shrink: 0;
    }
    .switch-toggle::after {
        content: ''; position: absolute; top: 3px; left: 3px; width: 20px; height: 20px;
        background: white; border-radius: 50%; transition: transform 0.3s; box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .switch-input { display: none; }
    .switch-input:checked + .switch-toggle { background: #22c55e; }
    .switch-input:checked + .switch-toggle::after { transform: translateX(22px); }
    .switch-label { font-size: 0.88rem; font-weight: 600; color: #334155; }

    .form-actions { display: flex; gap: 0.8rem; margin-top: 1.8rem; }
    .btn-save {
        flex: 1; padding: 0.85rem; background: linear-gradient(135deg, #f97316, #fb923c); color: white;
        border: none; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer;
        transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(249,115,22,0.3); }
    .btn-cancel {
        flex: 1; padding: 0.85rem; background: #f1f5f9; color: #64748b;
        border: none; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer;
        text-decoration: none; text-align: center; transition: all 0.3s; font-family: 'Montserrat', sans-serif;
    }
    .btn-cancel:hover { background: #e2e8f0; color: #475569; }

    .error-text { color: #ef4444; font-size: 0.8rem; font-weight: 600; margin-top: 0.3rem; }
</style>

<div class="form-container">
    <div class="form-box">
        <div class="form-box-header">
            <i class="fa-solid fa-pen-to-square"></i>
            <h3>Form Edit Kriteria</h3>
        </div>

        <form method="POST" action="/admin/ahp/criteria">
            @csrf
            <input type="hidden" name="id" value="{{ $criterium->id }}">

            <div class="form-group">
                <label for="name">Nama Kriteria</label>
                <input type="text" class="form-input" id="name" name="name"
                       value="{{ old('name', $criterium->name) }}" required>
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-input" id="description" name="description"
                          placeholder="Jelaskan kriteria ini...">{{ old('description', $criterium->description) }}</textarea>
                @error('description')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="order">Urutan</label>
                <input type="number" class="form-input" id="order" name="order"
                       value="{{ old('order', $criterium->order) }}" min="1">
                @error('order')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="weight">Bobot Kriteria (%)</label>
                <input type="number" class="form-input" id="weight" name="weight"
                       value="{{ old('weight', floatval($criterium->weight * 100)) }}" step="0.01" min="0" max="100" placeholder="0">
                @error('weight')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Status Kriteria</label>
                <div class="switch-group">
                    <input class="switch-input" type="checkbox" id="is_active" name="is_active" value="1"
                           {{ $criterium->is_active ? 'checked' : '' }}>
                    <label class="switch-toggle" for="is_active"></label>
                    <span class="switch-label">Aktif (Kriteria ini digunakan dalam perhitungan)</span>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk" style="margin-right: 0.3rem;"></i> Simpan Perubahan
                </button>
                <a href="/admin/ahp/criteria" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
