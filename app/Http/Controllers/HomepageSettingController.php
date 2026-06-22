<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageSetting;

class HomepageSettingController extends Controller
{
    public function edit()
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Hanya Super Admin yang dapat mengatur Beranda.');
        }

        // Ambil data pertama, jika tidak ada, buat data kosong dengan default values
        $setting = HomepageSetting::first();
        if (!$setting) {
            $setting = HomepageSetting::create([
                'hero_title' => 'Selamat Datang di <br> <span class="text-orange">Desa Mlideg</span>',
                'hero_subtitle' => 'Mewujudkan tata kelola desa yang transparan, mandiri, dan berdaya saing melalui digitalisasi pelayanan publik.',
                'sambutan_nama' => 'Erry Cahyono, S.H',
                'sambutan_jabatan' => 'Kepala Desa Mlideg',
                'sambutan_judul' => 'Membangun Desa Bersama Berbasis Digital',
                'sambutan_konten' => '"Assalamu\'alaikum Warahmatullahi Wabarakatuh. Puji syukur ke hadirat Tuhan YME atas peluncuran website profil Desa Mlideg. Kami berkomitmen untuk terus meningkatkan pelayanan publik melalui digitalisasi. Website ini merupakan wujud transparansi dan inovasi kami untuk memudahkan warga mengakses informasi dan layanan administrasi tanpa batas ruang dan waktu."'
            ]);
        }

        $hero_title_1 = 'Selamat Datang di';
        $hero_title_highlight = 'Desa Mlideg';
        
        if (preg_match('/^(.*?)(?:<br>\s*<span class="text-orange">)(.*?)(?:<\/span>)$/is', $setting->hero_title, $matches)) {
            $hero_title_1 = trim($matches[1]);
            $hero_title_highlight = trim($matches[2]);
        }

        return view('beranda-admin', [
            'role' => session('role'),
            'user' => session('user'),
            'setting' => $setting,
            'hero_title_1' => $hero_title_1,
            'hero_title_highlight' => $hero_title_highlight
        ]);
    }

    public function update(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'Super Admin') {
            return redirect('/dashboard');
        }

        $request->validate([
            'hero_title_1' => 'required|string',
            'hero_title_highlight' => 'required|string',
            'hero_subtitle' => 'required|string',
            'sambutan_nama' => 'required|string',
            'sambutan_jabatan' => 'required|string',
            'sambutan_judul' => 'required|string',
            'sambutan_konten' => 'required|string',
        ]);

        $setting = HomepageSetting::first();
        
        $data = $request->all();
        // Gabungkan teks biasa dan teks highlight dengan tag HTML
        $data['hero_title'] = $request->hero_title_1 . ' <br> <span class="text-orange">' . $request->hero_title_highlight . '</span>';
        
        $setting->update($data);

        return redirect('/admin/beranda')->with('success', 'Pengaturan Beranda berhasil diperbarui!');
    }
}
