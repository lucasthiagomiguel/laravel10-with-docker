<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'client_id' => Client::factory(),
            'code'      => strtoupper($this->faker->unique()->lexify('ORDER????')),
        ];
    }

    /**
     * Define a relação com produtos.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withProducts($count = 1)
    {
        return $this->hasAttached(
            Product::factory()->count($count),
            ['quantity' => $this->faker->numberBetween(1, 5)]
        );
    }
}
