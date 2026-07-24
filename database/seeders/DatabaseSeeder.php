<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeding database.
     *
     * Menggunakan updateOrCreate (bukan create) agar seeder ini aman
     * dijalankan berulang kali (idempotent) tanpa membuat data duplikat
     * jika email admin sudah ada sebelumnya.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cupos.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@cupos.id'],
            [
                'name' => 'Kasir',
                'password' => Hash::make('kasir123'),
                'email_verified_at' => now(),
                'role' => 'kasir',
            ]
        );

        User::updateOrCreate(
            ['email' => 'barista@cupos.id'],
            [
                'name' => 'Barista',
                'password' => Hash::make('barista123'),
                'email_verified_at' => now(),
                'role' => 'barista',
            ]
        );
    }
}