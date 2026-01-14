<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashOldPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hash-old-passwords'; // Nama command yang dipanggil di terminal

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hash semua password lama user dari plain text ke hash Laravel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil semua user
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // Update password menjadi hash
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'password' => Hash::make($user->password)
                ]);
        }

        $this->info("✅ Semua password lama sudah di-hash!");
    }
}
