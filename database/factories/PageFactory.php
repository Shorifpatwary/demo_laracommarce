<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
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
        } while (\App\Models\Page::where('name', $name)->exists());
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'title' => fake()->title(),
            'position' => rand(1, 3),
            'description' => fake()->randomHtml(),
        ];
    }
}
