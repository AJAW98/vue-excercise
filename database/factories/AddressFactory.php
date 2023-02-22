<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => fake()->streetAddress,
            'city' => fake()->city,
            'country' => fake()->country,
            'postal_code' => fake()->postcode,
        ];
    }
}
