<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Property Management', 'slug' => 'property-management', 'description' => 'Software for managing properties and tenants.', 'display_order' => 1],
            ['name' => 'Point of Sale', 'slug' => 'point-of-sale', 'description' => 'POS, inventory and retail solutions.', 'display_order' => 2],
            ['name' => 'Business Tools', 'slug' => 'business-tools', 'description' => 'General business productivity software.', 'display_order' => 3],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
