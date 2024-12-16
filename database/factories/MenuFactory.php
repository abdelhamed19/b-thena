<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->name,
            'item_description' => $this->faker->sentence,
            'item_price' => $this->faker->randomFloat(2, 0, 100),
            'is_active' => $this->faker->randomElement(['0', '1']),
        ];
    }
}
