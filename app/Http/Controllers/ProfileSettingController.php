<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileSetting;

class ProfileSettingController extends Controller
{
    public function edit()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Hanya Super Admin yang dapat mengatur Profil.');
        }

        // Ambil data pertama, jika tidak ada, buat data kosong dengan default values
        $setting = ProfileSetting::first();
        if (!$setting) {
            $setting = ProfileSetting::create([
                'sejarah' => 'Desa Mlideg memiliki sejarah panjang yang berakar dari masa babat alas tanah Jawa Timur. Nama "Mlideg" konon berasal dari kata lokal yang merujuk pada keteguhan hati para pendahulu dalam membangun pemukiman yang subur.',
                'geografis' => 'Berada di dataran subur Kabupaten Bojonegoro, Desa Mlideg berbatasan langsung dengan hamparan persawahan hijau. Desa ini terbagi menjadi beberapa Dusun strategis.',
                'visi' => '"Mewujudkan Desa Mlideg menjadi desa yang maju dalam segi pembangunan fisik, pelayanan masyarakat, pertanian, ekonomi kreatif, dan APBDes Pro Rakyat."',
                'misi' => '1. Maju dalam segi pembangunan fisik diwujudkan dengan menentukan kebijakan yang mendorong perkembangan pembangunan infrastruktur publik berbasis Ilmu Pengetahuan dan Teknologi (IPTEK)
2. Maju dalam segi pelayanan masyarakat diwujudkan dengan digitalisasi layanan, sistem jemput bola, pusat layanan terpadu, peningkatan SDM perangkat desa dan Lembaga Desa, serta aduan terbuka dan transparansi publik.
3. Maju dalam segi pertanian diwujudkan dengan pembangunan jalan usaha tani, penguatan irigasi, bantuan alat pertanian, pelatihan petani, serta dukungan bibit dan akses permodalan.
4. Maju dalam segi ekonomi kreatif diwujudkan dengan pelatihan UMKM, pengembangan produk lokal, pemasaran digital, pembentukan sentra kreatif, serta dukungan modal dan kemitraan usaha.
5. Maju dalam segi APBDesa Pro Rakyat diwujudkan dengan penyusunan partisipatif, alokasi anggaran berpihak pada kepentingan masyarakat, transparansi pengelolaan, serta efisiensi dan pemerataan pembangunan.',
                'struktur_organisasi' => 'Pemerintahan Desa Mlideg dipimpin oleh Kepala Desa, dibantu oleh Sekretaris Desa, para Kepala Urusan (Kaur), Kepala Seksi (Kasi), dan para Kepala Dusun (Kasun) yang bersinergi melayani masyarakat.'
            ]);
        }

        return view('profil-desa-admin', [
            'role' => session('role'),
            'user' => session('user'),
            'setting' => $setting
        ]);
    }

    public function update(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') {
            return redirect('/dashboard');
        }

        $request->validate([
            'sejarah' => 'required|string',
            'geografis' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'struktur_organisasi' => 'required|string',
        ]);

        $setting = ProfileSetting::first();
        $setting->update($request->all());

        return redirect('/admin/profil')->with('success', 'Pengaturan Profil berhasil diperbarui!');
    }
}
