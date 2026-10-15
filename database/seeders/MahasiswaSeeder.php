<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data mahasiswa untuk testing
        Mahasiswa::create([
            'npm' => '12345678901234',
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'prodi' => 'Teknik Informatika',
            'no_telp' => '081234567890',
        ]);

        Mahasiswa::create([
            'npm' => '12345678901235',
            'nama' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password123'),
            'prodi' => 'Sistem Informasi',
            'no_telp' => '081234567891',
        ]);

        Mahasiswa::create([
            'npm' => '12345678901236',
            'nama' => 'Ahmad Wijaya',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password123'),
            'prodi' => 'Ilmu Komputer',
            'no_telp' => '081234567892',
        ]);
    }
}
