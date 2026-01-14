<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipments = Equipment::all();
        $users = User::all();

        if ($equipments->isEmpty() || $users->isEmpty()) {
            return;
        }

        $statuses = ['open', 'in_progress', 'resolved'];
        $statusWeights = ['open' => 20, 'in_progress' => 30, 'resolved' => 50];

        // Générer exactement 5 maintenances avec Faker
        for ($i = 0; $i < 5; $i++) {
            $equipment = $equipments->random();
            $status = fake()->randomElement($statuses);
            $reportedAt = fake()->dateTimeBetween('-1 year', 'now');
            $resolvedAt = null;

            if ($status === 'resolved') {
                $resolvedAt = fake()->dateTimeBetween($reportedAt, 'now');
            } elseif ($status === 'in_progress') {
                // 50% de chance d'avoir une date de résolution même si en cours
                $resolvedAt = fake()->boolean(50) ? fake()->dateTimeBetween($reportedAt, 'now') : null;
            }

            Maintenance::create([
                'equipment_id' => $equipment->id,
                'reported_by' => $users->random()->id,
                'description' => fake()->paragraph(3),
                'status' => $status,
                'cost' => $status === 'resolved' ? fake()->numberBetween(100, 5000) : null,
                'reported_at' => $reportedAt,
                'resolved_at' => $resolvedAt,
            ]);

            // Mettre à jour le statut de l'équipement si nécessaire
            if ($status === 'open' || $status === 'in_progress') {
                $equipment->update(['status' => 'broken']);
            }
        }
    }
}
