<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subcategory>
 */
class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = '';
        do {
            $name = fake()->unique()->word();
        } while (\App\Models\Subcategory::where('name', $name)->exists());
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(15),
            'category_id' =>  Category::pluck('id')->random(),
            // 'image' => fake()->imageUrl(640, 480, 'animals', true),
            // 'post_id' => Post::pluck('id')->random(),
        ];
    }
}
