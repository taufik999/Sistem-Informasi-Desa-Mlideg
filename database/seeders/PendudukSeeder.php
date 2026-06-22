<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dusun = ['A', 'B', 'C'];
        $names = ['Budi Santoso', 'Siti Aminah', 'Haryono', 'Sri Wahyuni', 'M. Ilham', 'Ani Lestari', 'Joko Susilo', 'Rini Astuti'];
        
        foreach ($names as $index => $name) {
            \App\Models\Penduduk::create([
                'nik' => '352210123456000' . ($index + 1),
                'nkk' => '352210654321000' . ($index % 3 + 1),
                'nama' => $name,
                'jk' => $index % 2 == 0 ? 'L' : 'P',
                'tempat_lahir' => 'Bojonegoro',
                'tgl_lahir' => '198' . $index . '-0' . ($index + 1) . '-15',
                'alamat' => 'RT 0' . ($index % 5 + 1) . ' RW 01',
                'dusun' => $dusun[$index % 3],
                'agama' => 'Islam',
                'status_kawin' => 'Kawin',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Petani',
                'status' => 'Aktif'
            ]);
        }
    }
}
