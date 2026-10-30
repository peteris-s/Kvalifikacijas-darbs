<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class EmployeeUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('STOCKMANAGER_EMPLOYEE_PASSWORD');

        if (!$password || strlen($password) < 12) {
            throw new RuntimeException(
                'STOCKMANAGER_EMPLOYEE_PASSWORD nav norādīta vai ir pārāk īsa.'
            );
        }

        User::firstOrCreate(
            ['email' => 'employee@stockmanager.lv'],
            [
                'name' => 'StockManager Darbinieks',
                'password' => Hash::make($password),
                'role' => 'employee',
                'email_verified_at' => now(),
            ]
        );
    }
}
