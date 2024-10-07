<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address(),
            'complement' => $this->faker->optional()->streetAddress(),
            'neighborhood' => $this->faker->word(),
            'zip_code' => $this->faker->postcode(),
        ];
    }
}
