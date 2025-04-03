<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sku' => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{5}'),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'cost_price' => $this->faker->randomFloat(2, 1, 9999),
            'sale_price' => $this->faker->randomFloat(2, 1, 9999),
        ];
    }
}
