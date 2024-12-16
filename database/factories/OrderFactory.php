<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'order_number' => $this->faker->unique()->randomNumber(8),
            'customer_id' => 1,
            'total_price' => $this->faker->randomFloat(2, 100, 1000),
            'type' => $this->faker->randomElement(['take_away', 'delivery']),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'declined']),
        ];
    }
}
