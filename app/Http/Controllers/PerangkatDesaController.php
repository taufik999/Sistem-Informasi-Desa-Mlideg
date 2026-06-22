<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDesa;
use Illuminate\Http\Request;

class PerangkatDesaController extends Controller
{
    public function adminIndex()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/login');
        $perangkat = PerangkatDesa::orderBy('level')->orderBy('urutan')->get();
        // Variables needed by sidebar
        $role = session('role');
        $user = session('user');
        return view('perangkat-admin', compact('perangkat', 'role', 'user'));
    }

    public function show($id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/login');
        $role = session('role');
        $user = session('user');
        $perangkat = PerangkatDesa::findOrFail($id);
        return view('detail-perangkat', compact('perangkat', 'role', 'user'));
    }

    public function create()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/login');
        $role = session('role');
        $user = session('user');
        return view('tambah-perangkat', compact('role', 'user'));
    }

    public function store(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/login');
        
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'level' => 'required|integer'
        ]);

        PerangkatDesa::create($request->all());

        return redirect('/admin/perangkat')->with('success', 'Data Perangkat Desa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/login');
        $role = session('role');
        $user = session('user');
        $perangkat = PerangkatDesa::findOrFail($id);
        return view('edit-perangkat', compact('perangkat', 'role', 'user'));
    }

    public function update(Request $request, $id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/login');
        
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'level' => 'required|integer'
        ]);

        $perangkat = PerangkatDesa::findOrFail($id);
        $perangkat->update($request->all());

        return redirect('/admin/perangkat')->with('success', 'Data Perangkat Desa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/login');
        $perangkat = PerangkatDesa::findOrFail($id);
        $perangkat->delete();
        return redirect('/admin/perangkat')->with('success', 'Data Perangkat Desa berhasil dihapus!');
    }
}
