<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Izveido administratora kontu.
        $this->call(AdminUserSeeder::class);

        // Izveido darbinieka kontu.
        $this->call(EmployeeUserSeeder::class);
    }
}
