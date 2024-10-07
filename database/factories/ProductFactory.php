<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name'  => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'photo' => 'https://img.freepik.com/vetores-gratis/tela-realista-para-smartphone-com-aplicativos-diferentes_52683-30241.jpg',
        ];
    }
}
