<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'code' => fake()->unique()->word(),
            'unit' => fake()->optional()->word(),
            'tags' => fake()->optional()->word(),
            'color' => fake()->optional()->word(),
            'size' => fake()->optional()->word(),
            'video' => fake()->optional()->url(),
            'purchase_price' => fake()->optional()->randomFloat(2, 10, 1000),
            'selling_price' => fake()->randomFloat(2, 10, 1000),
            'discount_price' => fake()->optional()->randomFloat(2, 5, 500),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'description' => fake()->paragraph(),
            'thumbnail' => fake()->imageUrl(),
            'images' => fake()->optional()->imageUrl(),
            'featured' => fake()->boolean(),
            'today_deal' => fake()->boolean(),
            'product_slider' => fake()->boolean(),
            'trendy' => fake()->boolean(),
            'status' => fake()->randomElement([0, 1]),

            'category_id' => Category::pluck('id')->random(),
            'brand_id' => Brand::pluck('id')->random(),
            'warehouse_id' => Warehouse::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
        ];
    }
}
