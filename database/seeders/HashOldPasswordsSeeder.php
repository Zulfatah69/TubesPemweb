<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashOldPasswords extends Command
{
    protected $signature = 'users:hash-passwords';
    protected $description = 'Hash semua password lama user';

    public function handle()
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'password' => Hash::make($user->password)
                ]);
        }

        $this->info("Semua password lama sudah di-hash!");
    }
}
