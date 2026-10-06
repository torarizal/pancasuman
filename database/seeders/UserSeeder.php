<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Developer Account
        User::create([
            'name' => 'Super Developer',
            'email' => 'dev@pancasuman.com',
            'password' => Hash::make('password123'),
            'role' => 'developer',
        ]);

        // Admin Content Account
        User::create([
            'name' => 'Editor Konten',
            'email' => 'admin@pancasuman.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}