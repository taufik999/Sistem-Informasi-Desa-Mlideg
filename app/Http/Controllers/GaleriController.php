<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::orderBy('id', 'desc')->get();
        return view('galeri', compact('galeri'));
    }

    // Admin
    public function adminIndex()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        $galeri = Galeri::orderBy('id', 'desc')->get();
        return view('galeri-admin', ['role' => session('role'), 'user' => session('user'), 'galeri' => $galeri]);
    }

    public function store(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $safeName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $safeName;
            $file->move(public_path('storage/galeri'), $filename);
            $fotoPath = 'galeri/' . $filename;
            
            Galeri::create([
                'judul' => $request->input('judul'),
                'kategori' => $request->input('kategori'),
                'foto' => $fotoPath,
                'is_url' => false
            ]);
            return redirect('/admin/galeri')->with('success', 'Foto berhasil ditambahkan ke galeri!');
        }
        return redirect('/admin/galeri')->with('error', 'Gagal mengunggah foto.');
    }

    public function destroy($id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        Galeri::destroy($id);
        return redirect('/admin/galeri')->with('success', 'Foto berhasil dihapus!');
    }
}
