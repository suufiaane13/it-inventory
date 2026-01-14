<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin fixe (créer seulement s'il n'existe pas)
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'prenom' => 'Super',
                'tel' => '0123456789',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        // Générer 4 techniciens avec Faker (seulement si moins de 5 utilisateurs au total)
        $existingTechniciansCount = User::where('role', 'technician')->count();
        $techniciansToCreate = max(0, 4 - $existingTechniciansCount);

        for ($i = 0; $i < $techniciansToCreate; $i++) {
            User::create([
                'name' => fake()->lastName(),
                'prenom' => fake()->firstName(),
                'email' => fake()->unique()->safeEmail(),
                'tel' => $this->generatePhoneNumber(),
                'password' => Hash::make('password'),
                'role' => 'technician',
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
