<?php

namespace Database\Factories;

use App\Enums\SaleStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'total_profit' => $this->faker->randomFloat(2, 1, 100),
            'total_cost' => $this->faker->randomFloat(2, 1, 100),
            'total_amount' => $this->faker->numberBetween(1, 999),
            'status' => $this->faker->randomElement(SaleStatusEnum::values()),
        ];
    }
}
