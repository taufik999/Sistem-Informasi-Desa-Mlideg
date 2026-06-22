<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;

class SuratController extends Controller
{
    // Public
    public function create()
    {
        return view('ajuan-surat');
    }

    public function store(Request $request)
    {
        $trackId = 'SRT-' . strtoupper(substr(uniqid(), -6));

        $data = [
            'track_id' => $trackId,
            'tanggal' => date('d M Y'),
            'nik' => $request->input('nik'),
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis') === 'Lainnya' ? $request->input('jenis_lainnya') : $request->input('jenis'),
            'keperluan' => $request->input('keperluan'),
            'status' => 'Menunggu Validasi',
            'dokumen_pendukung' => null
        ];

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/dokumen_surat'), $filename);
            $data['dokumen_pendukung'] = 'dokumen_surat/' . $filename;
        }

        Surat::create($data);

        return redirect('/ajuan-surat')->with('success', 'Pengajuan surat Anda berhasil dikirim dan akan segera diproses oleh Pemerintah Desa.')->with('track_id', $trackId);
    }

    public function cekSurat(Request $request)
    {
        $surat = null;
        if ($request->has('track_id')) {
            $trackId = strtoupper(trim($request->input('track_id')));
            $surat = Surat::where('track_id', $trackId)->first();
            
            if (!$surat) {
                return redirect('/cek-surat')->with('error', 'Kode Pengajuan tidak ditemukan. Pastikan Anda memasukkan kode yang benar.');
            }
        }
        
        return view('cek-surat', ['surat' => $surat]);
    }

    // Admin
    public function adminIndex()
    {
        if (!session()->has('role')) return redirect('/login');
        
        $surat = Surat::orderBy('id', 'desc')->get();
        return view('surat-admin', ['role' => session('role'), 'user' => session('user'), 'surat' => $surat]);
    }

    public function updateStatus($id, $status)
    {
        if (!session()->has('role')) return redirect('/login');
        
        $surat = Surat::findOrFail($id);
        $surat->update(['status' => urldecode($status)]);
        
        return redirect('/admin/surat')->with('success', 'Status pengajuan surat berhasil diperbarui!');
    }
}
