<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'employee@stockmanager.lv'],
            [
                'name' => 'StockManager Darbinieks',
                'password' => Hash::make('Employee123!'),
                'role' => 'employee',
                'email_verified_at' => now(),
            ]
        );
    }
}
