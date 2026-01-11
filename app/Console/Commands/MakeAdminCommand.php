<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeAdminCommand extends Command
{
    protected $signature = 'make:admin {email} {--password=}';

    protected $description = 'Create or promote a user to admin role';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->option('password') ?? 'password123';

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->role = 'admin';
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->save();

            $this->info("User {$email} promoted to admin.");
            return Command::SUCCESS;
        }

        $username = explode('@', $email)[0];

        User::create([
            'name' => 'Admin',
            'username' => $username,
            'email' => $email,
            'phone' => '0000000000',
            'role' => 'admin',
            'password' => $password,
            'email_verified_at' => now(),
        ]);

        $this->info("Admin user created: {$email}");
        $this->info("Password: {$password}");

        return Command::SUCCESS;
    }
}
