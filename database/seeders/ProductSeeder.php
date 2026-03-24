<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure at least one category exists
        $category = Category::firstOrCreate(['name' => 'Cameras']);

        // Seed products with consistent brand values
        Product::create([
            'name'        => 'Sony Alpha A7',
            'brand'       => 'Sony',
            'description' => 'Full-frame mirrorless camera',
            'price'       => 120000,
            'stock'       => 10,
            'category_id' => $category->id,
        ]);

        Product::create([
            'name'        => 'Canon EOS R6',
            'brand'       => 'Canon',
            'description' => 'Mirrorless camera with fast autofocus',
            'price'       => 95000,
            'stock'       => 8,
            'category_id' => $category->id,
        ]);

        Product::create([
            'name'        => 'Nikon Z6 II',
            'brand'       => 'Nikon',
            'description' => 'Versatile mirrorless camera',
            'price'       => 105000,
            'stock'       => 5,
            'category_id' => $category->id,
        ]);
    }
}
