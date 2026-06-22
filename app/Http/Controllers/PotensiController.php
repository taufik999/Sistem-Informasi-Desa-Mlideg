<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Potensi;

class PotensiController extends Controller
{
    public function index()
    {
        $potensi = Potensi::orderBy('id', 'desc')->get();
        return view('potensi', compact('potensi'));
    }

    // Admin
    public function adminIndex()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        $potensi = Potensi::orderBy('id', 'desc')->get();
        return view('potensi-admin', ['role' => session('role'), 'user' => session('user'), 'potensi' => $potensi]);
    }

    public function store(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        
        $fotoPath = '';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/potensi'), $filename);
            $fotoPath = 'potensi/' . $filename;
        }
        
        Potensi::create([
            'judul' => $request->input('judul'),
            'kategori' => $request->input('kategori'),
            'deskripsi' => $request->input('deskripsi'),
            'full_desc' => $request->input('full_desc'),
            'foto' => $fotoPath,
            'is_url' => false
        ]);
        return redirect('/admin/potensi')->with('success', 'Potensi desa berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        Potensi::destroy($id);
        return redirect('/admin/potensi')->with('success', 'Potensi desa berhasil dihapus!');
    }
}
