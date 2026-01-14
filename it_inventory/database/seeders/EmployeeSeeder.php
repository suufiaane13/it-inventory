<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();

        if ($departments->isEmpty()) {
            return;
        }

        // Générer 5 employés avec Faker
        for ($i = 0; $i < 5; $i++) {
            Employee::create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => $this->generatePhoneNumber(),
                'department_id' => $departments->random()->id,
            ]);
        }
    }

    /**
     * Generate phone number in specific formats
     */
    private function generatePhoneNumber(): string
    {
        $formats = [
            '+212' . fake()->numerify('#########'), // +212 + 9 chiffres
            '+33' . fake()->numerify('#########'),  // +33 + 9 chiffres
            '06' . fake()->numerify('########'),    // 06 + 8 chiffres
            '07' . fake()->numerify('########'),     // 07 + 8 chiffres
        ];

        return fake()->randomElement($formats);
    }
}
