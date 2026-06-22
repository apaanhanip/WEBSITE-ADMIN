<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Coffee', 'description' => 'Minuman kopi premium dari biji pilihan'],
            ['name' => 'Non Coffee', 'description' => 'Minuman non-kopi segar dan menyegarkan'],
            ['name' => 'Dessert', 'description' => 'Pencuci mulut manis dan lezat'],
            ['name' => 'Snack', 'description' => 'Camilan ringan untuk menemani kopi'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
