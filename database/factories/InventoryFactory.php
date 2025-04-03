<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InventoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory()->create(),
            'quantity' => $this->faker->numberBetween(1, 30),
            'last_updated' => now(),
        ];
    }
}
