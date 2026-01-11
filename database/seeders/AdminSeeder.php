<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kosconnect.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'phone' => '08123456789',
                'password' => Hash::make('admin123'), // WAJIB bcrypt
                'role' => 'admin',
            ]
        );
    }
}
