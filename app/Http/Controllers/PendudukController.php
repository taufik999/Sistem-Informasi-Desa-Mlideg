<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Penduduk;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $query = Penduduk::orderBy('id', 'desc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('dusun') && $request->dusun != '') {
            $query->where('dusun', 'like', "%{$request->dusun}%");
        }
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', 'like', "%{$request->status}%");
        }

        $penduduk = $query->paginate(10)->withQueryString();
        
        return view('penduduk', ['role' => session('role'), 'user' => session('user'), 'penduduk' => $penduduk]);
    }

    public function create()
    {
        if (!session()->has('role')) return redirect('/login');
        return view('tambah-penduduk', ['role' => session('role'), 'user' => session('user')]);
    }

    public function store(Request $request)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduks,nik',
            'nkk' => 'required|digits:16'
        ], [
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar di sistem. Silakan periksa kembali.',
            'nkk.digits' => 'NKK harus tepat 16 digit angka.'
        ]);
        
        Penduduk::create($request->all());
        
        return redirect('/penduduk')->with('success', 'Data Penduduk ' . $request->input('nama') . ' berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!session()->has('role')) return redirect('/login');
        $p = Penduduk::findOrFail($id);
        return view('detail-penduduk', ['role' => session('role'), 'user' => session('user'), 'p' => $p]);
    }

    public function edit($id)
    {
        if (!session()->has('role')) return redirect('/login');
        $p = Penduduk::findOrFail($id);
        return view('edit-penduduk', ['role' => session('role'), 'user' => session('user'), 'p' => $p]);
    }

    public function update(Request $request, $id)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduks,nik,' . $id,
            'nkk' => 'required|digits:16'
        ], [
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'nik.unique' => 'NIK ini sudah digunakan oleh data penduduk lain.',
            'nkk.digits' => 'NKK harus tepat 16 digit angka.'
        ]);
        
        $p = Penduduk::findOrFail($id);
        $p->update($request->all());
        return redirect('/penduduk')->with('success', 'Data Penduduk berhasil diperbarui!');
    }

    public function daftarKk()
    {
        if (!session()->has('role')) return redirect('/login');
        
        $kks = Penduduk::selectRaw('nkk, count(id) as jumlah_anggota')
            ->groupBy('nkk')
            ->orderBy('nkk', 'asc')
            ->get();
            
        foreach ($kks as $kk) {
            $kepala = Penduduk::where('nkk', $kk->nkk)->where('hubungan_keluarga', 'Kepala Keluarga')->first();
            if (!$kepala) {
                // Fallback to first if no Kepala Keluarga is defined yet
                $kepala = Penduduk::where('nkk', $kk->nkk)->first();
            }
            $kk->kepala_keluarga = $kepala ? $kepala->nama : 'Tidak Diketahui';
            $kk->alamat = $kepala ? $kepala->alamat : '-';
        }

        return view('kk-admin', [
            'role' => session('role'),
            'user' => session('user'),
            'kks' => $kks
        ]);
    }

    public function detailKk($nkk)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $anggota = Penduduk::where('nkk', $nkk)->get();
        $kepala = $anggota->where('hubungan_keluarga', 'Kepala Keluarga')->first();
        if (!$kepala) {
            $kepala = $anggota->first();
        }
        
        return view('detail-kk', [
            'role' => session('role'), 
            'user' => session('user'), 
            'nkk' => $nkk,
            'anggota' => $anggota,
            'kepala' => $kepala
        ]);
    }

    public function createKk()
    {
        if (!session()->has('role')) return redirect('/login');
        // Redirect ke form tambah penduduk untuk kepala keluarga baru
        return redirect('/penduduk/tambah')->with('success', 'Silakan isi data Kepala Keluarga baru untuk membuat Kartu Keluarga (KK) baru.');
    }

    public function editKk($nkk)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $anggota = Penduduk::where('nkk', $nkk)->get();
        if ($anggota->isEmpty()) return redirect('/admin/kk')->with('error', 'Data KK tidak ditemukan!');
        
        $kepala = $anggota->where('hubungan_keluarga', 'Kepala Keluarga')->first();
        if (!$kepala) {
            $kepala = $anggota->first();
        }
        return view('edit-kk', [
            'role' => session('role'),
            'user' => session('user'),
            'nkk' => $nkk,
            'kepala' => $kepala
        ]);
    }

    public function updateKk(Request $request, $nkk)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $newNkk = $request->input('nkk');
        $newAlamat = $request->input('alamat');
        
        // Update massal NKK dan Alamat untuk semua anggota keluarga ini
        Penduduk::where('nkk', $nkk)->update([
            'nkk' => $newNkk,
            'alamat' => $newAlamat
        ]);
        
        return redirect('/admin/kk')->with('success', 'Data Kartu Keluarga berhasil diperbarui!');
    }

    public function destroyKk($nkk)
    {
        if (!session()->has('role')) return redirect('/login');
        
        // Hapus massal seluruh anggota keluarga di bawah NKK ini
        Penduduk::where('nkk', $nkk)->delete();
        
        return redirect('/admin/kk')->with('success', 'Data Kartu Keluarga beserta seluruh anggotanya berhasil dihapus!');
    }

    public function destroy($id)
    {
        if (!session()->has('role')) return redirect('/login');
        $p = Penduduk::findOrFail($id);
        $p->delete();
        return redirect('/penduduk')->with('success', 'Data Penduduk berhasil dihapus!');
    }

    public function cekNik(Request $request)
    {
        $nik = $request->input('nik');
        if (!$nik) return response()->json(['success' => false]);
        
        $penduduk = Penduduk::where('nik', $nik)->first();
        if ($penduduk) {
            return response()->json(['success' => true, 'nama' => $penduduk->nama]);
        }
        return response()->json(['success' => false]);
    }
}
