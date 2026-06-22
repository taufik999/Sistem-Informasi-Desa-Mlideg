@extends('layouts.admin')

@section('header_title', 'Manajemen Role & Pengguna')
@section('header_subtitle', 'Kelola Hak Akses dan Akun Admin')

@section('header_action')
    <a href="/admin/users/tambah" class="btn-tambah">
        <i class="fa-solid fa-plus"></i> Tambah Pengguna
    </a>
@endsection

@section('content')
<style>
    .btn-tambah {
        padding: 0.7rem 1.2rem; background-color: #f97316; color: white;
        border-radius: 8px; font-weight: 700; font-size: 0.9rem; 
        display: flex; align-items: center; gap: 0.5rem; text-decoration: none;
        transition: all 0.3s;
    }
    .btn-tambah:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(249,115,22,0.3); color: white;}

    .table-container {
        background-color: #fff; border-radius: 12px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .data-table { width: 100%; border-collapse: collapse; min-width: 750px; }
    .data-table th { 
        text-align: left; padding: 1.2rem 1.5rem; background-color: #f8fafc; 
        color: #475569; font-weight: 700; font-size: 0.85rem; border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .data-table td { 
        padding: 1.2rem 1.5rem; border-bottom: 1px solid #f1f5f9; 
        font-size: 0.95rem; color: #334155; font-weight: 500;
    }
    .data-table tr:hover { background-color: #f8fafc; }
    
    .action-btns { display: flex; gap: 0.5rem; }
    .action-btn { 
        width: 32px; height: 32px; border-radius: 6px; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; color: white; transition: opacity 0.3s;
        text-decoration: none;
    }
    .action-btn:hover { opacity: 0.8; color: white; }
    .btn-edit { background-color: #3b82f6; }
    .btn-delete { background-color: #ef4444; }

    .role-badge {
        padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-block;
    }
    .role-super { background-color: #fee2e2; color: #b91c1c; }
    .role-dusun { background-color: #dbeafe; color: #1d4ed8; }
</style>

@if(session('success'))
    <div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
        <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
        <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.2rem;"></i> {{ session('error') }}
    </div>
@endif

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Lengkap</th>
                <th width="20%">Username</th>
                <th width="25%">Role/Hak Akses</th>
                <th width="15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $u)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $u->name }}</strong></td>
                <td><span style="font-family: monospace; color: #64748b; background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">{{ $u->username }}</span></td>
                <td>
                    <span class="role-badge {{ $u->role === 'Super Admin' ? 'role-super' : 'role-dusun' }}">
                        {{ $u->role === 'Super Admin' ? 'Sekretaris Desa' : $u->role }}
                    </span>
                </td>
                <td>
                    <div class="action-btns">
                        <a href="/admin/users/{{ $u->id }}/edit" class="action-btn btn-edit" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                        @if($u->id !== session('user_id'))
                        <a href="/admin/users/{{ $u->id }}/delete" class="action-btn btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"><i class="fa-solid fa-trash-can"></i></a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
