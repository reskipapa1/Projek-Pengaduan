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
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'password' => bcrypt('password'), // password default: password
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );

        \App\Models\Profile::firstOrCreate(
            ['user_id' => $superAdmin->id],
            [
                'Nik' => '0000000000000001',
                'name' => 'Super Administrator',
                'alamat' => 'bukit_raya',
                'no_telp' => '081111111111',
            ]
        );

        // 2. Buat akun Konsumen (User biasa)
        $konsumen = User::firstOrCreate(
            ['email' => 'konsumen@example.com'],
            [
                'password' => bcrypt('password'), // password default: password
                'role' => User::ROLE_KONSUMEN,
            ]
        );

        \App\Models\Profile::firstOrCreate(
            ['user_id' => $konsumen->id],
            [
                'Nik' => '1111111111111111',
                'name' => 'Budi Konsumen',
                'alamat' => 'bukit_raya',
                'no_telp' => '081234567890',
            ]
        );

        // 3. Buat akun Kepala Bagian
        $kepalaBagian = User::firstOrCreate(
            ['email' => 'kepalabagian@example.com'],
            [
                'password' => bcrypt('password'),
                'role' => User::ROLE_KEPALA_BAGIAN,
            ]
        );

        \App\Models\Profile::firstOrCreate(
            ['user_id' => $kepalaBagian->id],
            [
                'Nik' => '2222222222222222',
                'name' => 'Siti Kepala Bagian',
                'alamat' => 'marpoyan_damai',
                'no_telp' => '082222222222',
            ]
        );

        // 4. Buat akun Admin Penanganan
        $adminPenanganan = User::firstOrCreate(
            ['email' => 'adminpenanganan@example.com'],
            [
                'password' => bcrypt('password'),
                'role' => User::ROLE_ADMIN_PENANGANAN,
            ]
        );

        \App\Models\Profile::firstOrCreate(
            ['user_id' => $adminPenanganan->id],
            [
                'Nik' => '3333333333333333',
                'name' => 'Agus Admin Penanganan',
                'alamat' => 'senapelan',
                'no_telp' => '083333333333',
            ]
        );

         $adminPenanganan = User::firstOrCreate(
            ['email' => 'adminpenanganan1@example.com'],
            [
                'password' => bcrypt('password'),
                'role' => User::ROLE_ADMIN_PENANGANAN,
            ]
        );

        \App\Models\Profile::firstOrCreate(
            ['user_id' => $adminPenanganan->id],
            [
                'Nik' => '4444444444444444',
                'name' => 'Admin Penanganan 2',
                'alamat' => 'senapelan',
                'no_telp' => '083333333335',
            ]
        );
    }
}
