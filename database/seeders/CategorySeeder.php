<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allCategories = [
            "T-Shirts",
            "Sweatshirts",
            "Hoodies",
            "Jackets",
            "Pants",
            "Shorts",
            "Shoes",
            "Accessories",
        ];

        foreach ($allCategories as $category) {
            Category::create([
                "name" => $category,
            ]);
        }
    }
}
