<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('STOCKMANAGER_ADMIN_PASSWORD');

        if (!$password || strlen($password) < 12) {
            throw new RuntimeException(
                'STOCKMANAGER_ADMIN_PASSWORD nav norādīta vai ir pārāk īsa.'
            );
        }

        User::firstOrCreate(
            ['email' => 'admin@stockmanager.lv'],
            [
                'name' => 'StockManager Admin',
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
