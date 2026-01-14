<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipments = Equipment::all();
        $employees = Employee::all();
        $users = User::all();

        if ($equipments->isEmpty() || $employees->isEmpty() || $users->isEmpty()) {
            return;
        }

        // Générer exactement 5 assignations
        $selectedEquipments = $equipments->random(min(5, $equipments->count()));
        
        foreach ($selectedEquipments as $equipment) {
            $assignedAt = fake()->dateTimeBetween('-6 months', 'now');
            $returnedAt = fake()->boolean(30) ? fake()->dateTimeBetween($assignedAt, 'now') : null;

            Assignment::create([
                'equipment_id' => $equipment->id,
                'employee_id' => $employees->random()->id,
                'user_id' => $users->random()->id,
                'assigned_at' => $assignedAt,
                'returned_at' => $returnedAt,
                'notes' => fake()->optional()->sentence(),
            ]);

            // Mettre à jour le statut de l'équipement si l'assignation est active
            if (!$returnedAt) {
                $equipment->update(['status' => 'assigned']);
            }
        }
    }
}
