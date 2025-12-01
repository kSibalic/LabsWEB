<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ferit.hr',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Nastavnik Test',
            'email' => 'nastavnik@ferit.hr',
            'password' => Hash::make('nastavnik'),
            'role' => 'nastavnik',
        ]);

        User::create([
            'name' => 'Student Test',
            'email' => 'student@ferit.hr',
            'password' => Hash::make('student'),
            'role' => 'student',
        ]);
    }
}
