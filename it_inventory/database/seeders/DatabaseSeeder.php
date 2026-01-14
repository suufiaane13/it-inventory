<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            EquipmentSeeder::class,
            AssignmentSeeder::class,
            MaintenanceSeeder::class,
        ]);
    }
}
