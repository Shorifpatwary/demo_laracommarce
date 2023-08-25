<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->word,
            'valid_date' => fake()->dateTimeThisYear(),
            'type' => fake()->randomElement([1, 2, 3]), // Replace with your specific options
            'amount' => fake()->numberBetween(10, 100), // Adjust range as needed
            'status' => fake()->randomElement(['active', 'inactive', 'expired']),
        ];
    }
}
