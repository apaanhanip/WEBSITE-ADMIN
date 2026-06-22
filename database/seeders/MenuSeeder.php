<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            'Coffee' => [
                ['name' => 'Espresso', 'price' => 18000, 'description' => 'Single shot espresso klasik'],
                ['name' => 'Cappuccino', 'price' => 28000, 'description' => 'Espresso dengan steamed milk foam'],
                ['name' => 'Latte', 'price' => 30000, 'description' => 'Espresso dengan susu steamed lembut'],
                ['name' => 'Americano', 'price' => 22000, 'description' => 'Espresso dengan air panas'],
                ['name' => 'Mocha', 'price' => 35000, 'description' => 'Latte dengan cokelat premium'],
            ],
            'Non Coffee' => [
                ['name' => 'Matcha Latte', 'price' => 32000, 'description' => 'Teh matcha Jepang dengan susu'],
                ['name' => 'Chocolate', 'price' => 28000, 'description' => 'Cokelat panas creamy'],
                ['name' => 'Lemon Tea', 'price' => 18000, 'description' => 'Teh lemon segar'],
                ['name' => 'Fresh Orange', 'price' => 22000, 'description' => 'Jus jeruk segar'],
            ],
            'Dessert' => [
                ['name' => 'Cheesecake', 'price' => 35000, 'description' => 'Cheesecake klasik New York style'],
                ['name' => 'Brownies', 'price' => 25000, 'description' => 'Brownies cokelat fudgy'],
                ['name' => 'Tiramisu', 'price' => 38000, 'description' => 'Tiramisu Italia autentik'],
            ],
            'Snack' => [
                ['name' => 'Croissant', 'price' => 22000, 'description' => 'Croissant butter renyah'],
                ['name' => 'Sandwich', 'price' => 32000, 'description' => 'Sandwich ayam dan sayur'],
                ['name' => 'French Fries', 'price' => 20000, 'description' => 'Kentang goreng crispy'],
            ],
        ];

        foreach ($menus as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->first();
            if (! $category) {
                continue;
            }

            foreach ($items as $item) {
                Menu::updateOrCreate(
                    ['name' => $item['name'], 'category_id' => $category->id],
                    array_merge($item, ['category_id' => $category->id, 'is_available' => true])
                );
            }
        }
    }
}
