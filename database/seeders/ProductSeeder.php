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
            'photo' => 'https://img.freepik.com/vetores-gratis/tela-realista-para-smartphone-com-aplicativos-diferentes_52683-30241.jpg',
        ]);

        Product::create([
            'name' => 'Produto 2',
            'price' => 15.50,
            'photo' => 'https://img.freepik.com/vetores-gratis/tela-realista-para-smartphone-com-aplicativos-diferentes_52683-30241.jpg'
        ]);

        Product::create([
            'name' => 'Produto 3',
            'price' => 20.00,
            'photo' => 'https://img.freepik.com/vetores-gratis/tela-realista-para-smartphone-com-aplicativos-diferentes_52683-30241.jpg',
        ]);
    }
}
