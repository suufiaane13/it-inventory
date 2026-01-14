<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Direction', 'description' => 'Direction générale de l\'entreprise'],
            ['name' => 'Ressources Humaines', 'description' => 'Gestion des ressources humaines et du personnel'],
            ['name' => 'Informatique', 'description' => 'Service informatique et gestion du parc IT'],
            ['name' => 'Comptabilité', 'description' => 'Gestion financière et comptable'],
            ['name' => 'Commercial', 'description' => 'Service commercial et vente'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
