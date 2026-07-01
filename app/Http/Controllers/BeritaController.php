<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('status', 'Published')->orderBy('id', 'desc')->get();
        return view('berita', compact('berita'));
    }

    public function show($id)
    {
        $beritaDetail = Berita::findOrFail($id);
        
        $isAdmin = session()->has('role');
        if (!$isAdmin && $beritaDetail->status !== 'Published') {
            return redirect('/berita')->with('error', 'Berita tidak ditemukan atau sudah tidak tersedia.');
        }

        $beritaDetail->increment('views');
        return view('detail-berita', ['berita' => $beritaDetail]);
    }

    // Admin
    public function adminIndex()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard')->with('error', 'Akses Ditolak');
        $berita = Berita::orderBy('id', 'desc')->get();
        return view('berita-admin', ['role' => session('role'), 'user' => session('user'), 'berita' => $berita]);
    }

    public function create()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        return view('tambah-berita', ['role' => session('role'), 'user' => session('user')]);
    }

    public function store(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $safeName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $safeName;
            $file->move(public_path('storage/berita'), $filename);
            $fotoPath = 'berita/' . $filename;
        }

        Berita::create([
            'judul' => $request->input('judul'),
            'tanggal' => now(),
            'status' => $request->input('status'),
            'penulis' => session('user'),
            'views' => 0,
            'foto' => $fotoPath,
            'konten' => $request->input('konten')
        ]);

        return redirect('/admin/berita')->with('success', 'Berita baru berhasil diterbitkan!');
    }

    public function adminShow($id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        $berita = Berita::findOrFail($id);
        return view('detail-berita-admin', ['role' => session('role'), 'user' => session('user'), 'berita' => $berita]);
    }

    public function edit($id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        $berita = Berita::findOrFail($id);
        return view('edit-berita', ['role' => session('role'), 'user' => session('user'), 'berita' => $berita]);
    }

    public function update(Request $request, $id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        
        $berita = Berita::findOrFail($id);
        
        $data = [
            'judul' => $request->input('judul'),
            'status' => $request->input('status'),
            'konten' => $request->input('konten')
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $safeName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $safeName;
            $file->move(public_path('storage/berita'), $filename);
            $data['foto'] = 'berita/' . $filename;
        }

        $berita->update($data);
        return redirect('/admin/berita')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') return redirect('/dashboard');
        Berita::destroy($id);
        return redirect('/admin/berita')->with('success', 'Berita berhasil dihapus!');
    }
}
