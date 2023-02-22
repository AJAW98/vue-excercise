<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = (new Car())->getTypes();
        $item = $types[array_rand($types)];

        return [
            'make' => $item['make'],
            'model' => $item['model'],
            'year' => $item['year'],
        ];
    }
}
