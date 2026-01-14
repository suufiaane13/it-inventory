<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Ordinateur Portable', 'type' => 'hardware', 'description' => 'Laptops et notebooks'],
            ['name' => 'Ordinateur Bureau', 'type' => 'hardware', 'description' => 'PC de bureau'],
            ['name' => 'Écran', 'type' => 'hardware', 'description' => 'Moniteurs et écrans'],
            ['name' => 'Imprimante', 'type' => 'hardware', 'description' => 'Imprimantes et scanners'],
            ['name' => 'Accessoires', 'type' => 'accessory', 'description' => 'Claviers, souris et autres accessoires'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
