<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return;
        }

        $equipments = [
            [
                'name' => 'Dell Latitude 5520',
                'brand' => 'Dell',
                'model' => 'Latitude 5520',
                'serial_number' => 'SN-DELL-001',
                'category' => 'Ordinateur Portable',
                'image' => 'dell-Ordinateur Portable.webp',
                'status' => 'available',
                'purchase_date' => now()->subMonths(6),
                'warranty_duration' => 24,
            ],
            [
                'name' => 'HP ProDesk 600',
                'brand' => 'HP',
                'model' => 'ProDesk 600',
                'serial_number' => 'SN-HP-001',
                'category' => 'Ordinateur Bureau',
                'image' => 'ordinateur-bureau.webp',
                'status' => 'assigned',
                'purchase_date' => now()->subMonths(12),
                'warranty_duration' => 36,
            ],
            [
                'name' => 'Dell B2360dn',
                'brand' => 'Dell',
                'model' => 'B2360dn',
                'serial_number' => 'SN-DELL-PRINT-001',
                'category' => 'Imprimante',
                'image' => 'imprimante.webp',
                'status' => 'available',
                'purchase_date' => now()->subMonths(8),
                'warranty_duration' => 12,
            ],
            [
                'name' => 'Microsoft Surface Display',
                'brand' => 'Microsoft',
                'model' => 'Surface Display 27"',
                'serial_number' => 'SN-MS-001',
                'category' => 'Écran',
                'image' => 'Microsoft-ecran.webp',
                'status' => 'assigned',
                'purchase_date' => now()->subMonths(4),
                'warranty_duration' => 24,
            ],
            [
                'name' => 'Canon PIXMA G6020',
                'brand' => 'Canon',
                'model' => 'PIXMA G6020',
                'serial_number' => 'SN-CANON-001',
                'category' => 'Imprimante',
                'image' => 'Canon.webp',
                'status' => 'available',
                'purchase_date' => now()->subMonths(3),
                'warranty_duration' => 12,
            ],
        ];

        foreach ($equipments as $equipmentData) {
            $category = $categories->firstWhere('name', $equipmentData['category']);
            
            if (!$category) {
                $category = $categories->first();
            }

            Equipment::create([
                'name' => $equipmentData['name'],
                'brand' => $equipmentData['brand'],
                'model' => $equipmentData['model'],
                'serial_number' => $equipmentData['serial_number'],
                'category_id' => $category->id,
                'status' => $equipmentData['status'],
                'purchase_date' => $equipmentData['purchase_date'],
                'warranty_duration' => $equipmentData['warranty_duration'],
                'image_path' => 'equipments/' . $equipmentData['image'],
            ]);
        }
    }
}
