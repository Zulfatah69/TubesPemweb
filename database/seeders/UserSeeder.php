<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'phone' => '0800000001',
            'role' => 'admin',
            'password' => 'password123',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Owner',
            'username' => 'owner',
            'email' => 'owner@test.com',
            'phone' => '0800000002',
            'role' => 'owner',
            'password' => 'password123',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@test.com',
            'phone' => '0800000003',
            'role' => 'user',
            'password' => 'password123',
            'email_verified_at' => now(),
        ]);
    }
}
