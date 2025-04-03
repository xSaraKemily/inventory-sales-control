<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{5}'),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'cost_price' => $this->faker->randomFloat(2, 1, 9999),
            'sale_price' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
