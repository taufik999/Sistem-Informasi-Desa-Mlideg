<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Sekretaris Desa',
            'username' => 'superadmin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'Super Admin',
        ]);

        // Admin Dusun A
        User::create([
            'name' => 'Kepala Dusun A',
            'username' => 'admindusuna',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'Admin Dusun A',
        ]);

        // Admin Dusun B
        User::create([
            'name' => 'Kepala Dusun B',
            'username' => 'admindusunb',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'Admin Dusun B',
        ]);

        // Admin Dusun C
        User::create([
            'name' => 'Kepala Dusun C',
            'username' => 'admindusunc',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'Admin Dusun C',
        ]);
    }
}
