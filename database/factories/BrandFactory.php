<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'logo' => fake()->imageUrl(200, 200, 'brands', true), // Generates a fake logo image URL
            'front_page' => fake()->boolean(),
        ];
    }
}
