<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sale_id' => Sale::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 30),
            'unit_price' => $this->faker->randomFloat(2, 1, 9999),
            'unit_cost' => $this->faker->randomFloat(2, 1, 9999),
        ];
    }
}
