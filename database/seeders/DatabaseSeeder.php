<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Prime Laundry',
            'email' => 'admin@primelaundry.com',
            'password' => Hash::make('Admin@Prime2026'), // Password asli kamu
            'role' => 'admin', // Catatan: Jika eror, ganti bagian ini jadi 'is_admin' => true sesuai kolom migrasimu
        ]);
    }
}