<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'phone' => '0800000001',
                'role' => 'admin',
                'password' => 'password123',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['username' => 'owner'],
            [
                'name' => 'Owner',
                'email' => 'owner@test.com',
                'phone' => '0800000002',
                'role' => 'owner',
                'password' => 'password123',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['username' => 'user'],
            [
                'name' => 'User',
                'email' => 'user@test.com',
                'phone' => '0800000003',
                'role' => 'user',
                'password' => 'password123',
                'email_verified_at' => now(),
            ]
        );
    }
}
