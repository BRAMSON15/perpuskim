<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Staf;

class StafSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staf::updateOrCreate(
            ['username' => 'staf1'],
            [
                'nama' => 'Staf Perpustakaan 1',
                'password' => Hash::make('password123'),
                'role' => 'staf',
            ]
        );

        Staf::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Admin Utama',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
