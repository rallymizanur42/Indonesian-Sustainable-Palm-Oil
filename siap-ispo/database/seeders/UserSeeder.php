<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ispo.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Sample Pekebun
        User::create([
            'name' => 'Petani Sawit',
            'email' => 'pekebun@ispo.com',
            'password' => Hash::make('password123'),
            'role' => 'pekebun',
            'email_verified_at' => now(),
        ]);

        // Create additional pekebun
        User::create([
            'name' => 'Heri Susilo',
            'email' => 'heri@ispo.com',
            'password' => Hash::make('password123'),
            'role' => 'pekebun',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Salwa Destrin Karin',
            'email' => 'Salwa@ispo.com',
            'password' => Hash::make('password123'),
            'role' => 'pekebun',
            'email_verified_at' => now(),
        ]);

        echo "UserSeeder berhasil dijalankan!\n";
    }
}
