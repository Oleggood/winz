<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@winzi.ru',
            'email_verified_at' => now(),
            'name' => 'winzi_admin',
            'password' => Hash::make('1q2w3e4r5'),
            'online' => now(),
            'role' => 100,
        ]);
    }
}
