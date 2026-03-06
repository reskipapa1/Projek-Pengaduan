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
        // 1. Buat akun Super Admin
        $superAdmin = User::create([
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'), // password default: password
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        \App\Models\profile::create([
            'user_id' => $superAdmin->id,
            'Nik' => '0000000000000001',
            'name' => 'Super Administrator',
            'alamat' => 'bukit_raya',
            'no_telp' => '081111111111',
        ]);

        // 2. Buat akun Konsumen (User biasa)
        $konsumen = User::create([
            'email' => 'konsumen@example.com',
            'password' => bcrypt('password'), // password default: password
            'role' => User::ROLE_KONSUMEN,
        ]);

        \App\Models\profile::create([
            'user_id' => $konsumen->id,
            'Nik' => '1111111111111111',
            'name' => 'Budi Konsumen',
            'alamat' => 'bukit_raya',
            'no_telp' => '081234567890',
        ]);
    }
}
