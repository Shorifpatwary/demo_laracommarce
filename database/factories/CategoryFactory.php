<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // $name = $faker->unique()->word; // Generate a unique word for the category name
    // $slug = Str::slug($name); // Generate the slug from the name
    public function definition(): array
    {
        $name = '';
        do {
            $name = fake()->unique()->word();
        } while (\App\Models\Category::where('name', $name)->exists());
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(15),
            // 'image' => fake()->imageUrl(640, 480, 'animals', true),
            // 'post_id' => Post::pluck('id')->random(),
        ];
    }
}