<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Produto 1',
            'price' => 10.00,
            'photo' => 'path/to/photo1.jpg', 
            'product_type_id' => 1
        ]);

        Product::create([
            'name' => 'Produto 2',
            'price' => 15.50,
            'photo' => 'path/to/photo2.jpg',
            'product_type_id' => 2
        ]);

        Product::create([
            'name' => 'Produto 3',
            'price' => 20.00,
            'photo' => 'path/to/photo3.jpg',
            'product_type_id' => 1
        ]);
    }
}
