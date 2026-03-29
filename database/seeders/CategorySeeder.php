<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\ProductCategory;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $cat = Category::firstOrCreate(['name' => "Category $i"], [
                'description' => "Description for Category $i",
                'is_active' => true,
            ]);

            ProductCategory::firstOrCreate(['category_id' => $cat->id, 'name' => "Subcategory A for $cat->name"], [
                'description' => '...',
                'is_active' => true,
            ]);

            ProductCategory::firstOrCreate(['category_id' => $cat->id, 'name' => "Subcategory B for $cat->name"], [
                'description' => '...',
                'is_active' => true,
            ]);
        }
    }
}
