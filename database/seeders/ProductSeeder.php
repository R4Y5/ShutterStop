<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $dslr       = Category::firstOrCreate(['name' => 'DSLR']);
        $mirrorless = Category::firstOrCreate(['name' => 'Mirrorless']);
        $action     = Category::firstOrCreate(['name' => 'Action Camera']);
        $compact    = Category::firstOrCreate(['name' => 'Compact']);

        // DSLR
        Product::create([
            'name'        => 'Canon EOS 90D',
            'brand'       => 'Canon',
            'description' => 'High-performance DSLR with 32.5MP sensor',
            'price'       => 85000,
            'stock'       => 7,
            'category_id' => $dslr->id,
        ]);

        // Mirrorless
        Product::create([
            'name'        => 'Sony Alpha A7 IV',
            'brand'       => 'Sony',
            'description' => 'Full-frame mirrorless with 33MP sensor and 4K video',
            'price'       => 135000,
            'stock'       => 6,
            'category_id' => $mirrorless->id,
        ]);

        // Action Camera
        Product::create([
            'name'        => 'GoPro Hero 12 Black',
            'brand'       => 'GoPro',
            'description' => 'Waterproof action camera with 5.3K video',
            'price'       => 25000,
            'stock'       => 15,
            'category_id' => $action->id,
        ]);

        // Compact
        Product::create([
            'name'        => 'Canon PowerShot G7 X III',
            'brand'       => 'Canon',
            'description' => 'Compact camera with 1-inch sensor, ideal for vlogging',
            'price'       => 45000,
            'stock'       => 10,
            'category_id' => $compact->id,
        ]);
    }
}