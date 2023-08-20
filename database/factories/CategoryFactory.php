<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // $name = $faker->unique()->word; // Generate a unique word for the category name
    // $slug = Str::slug($name); // Generate the slug from the name
    // public function definition(): array
    // {
    //     $name = '';
    //     do {
    //         $name = fake()->unique()->word();
    //     } while Category::where('name', $name)->exists());

    //     return [
    //         'name' => $name,
    //         'slug' => Str::slug($name),
    //         'description' => fake()->sentence(15),
    //         // 'image' => fake()->imageUrl(640, 480, 'animals', true),
    //         // 'post_id' => Post::pluck('id')->random(),
    //     ];
    // }

    public function definition(): array
    {
        $name = '';
        do {
            $name = fake()->unique()->word();
        } while (Category::where('name', $name)->exists());

        $mainCategoryExists = Category::where('parent_id', null)->exists();

        if (!$mainCategoryExists) {
            // Create a dummy main category if none exists
            return [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => fake()->sentence(15),
                // 'parent_id' => 0,
            ];
        } else {

            $categoryType = null; // Generate a random number from 1 to 15. 1 for main category. 2 to 5 for sub category. 6 to 15 for sub child category 
            $mainCategoryCount = Category::where('parent_id', null)->count();
            $subCategoryCount = Category::where('parent_id', '!=', null)->count();
            $subChildCategoryCount = Category::where('parent_id', '!=', null)->count();
            if ($mainCategoryCount) {
                if (!$subCategoryCount || $mainCategoryCount >=  $subCategoryCount) {
                    $categoryType = rand(2, 5);
                }
            } elseif ($subCategoryCount) {
                if (!$$subChildCategoryCount || $subCategoryCount >=  $subChildCategoryCount) {
                    $categoryType = rand(6, 15);
                }
            } else {
                $categoryType = 1; // rand(1, 15);
            }

            // Define $mainCategory and $subCategory 
            $mainCategory = Category::where('parent_id', null)->inRandomOrder()->first();
            $subCategory = Category::where('parent_id', $mainCategory->id)->inRandomOrder()->first();

            $attributes = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => fake()->sentence(15),
            ];

            // Set parent_id based on category type
            if ($categoryType === 1) {
                // Main Category
                $attributes['parent_id'] = null;
            } elseif ($categoryType >= 2 && $categoryType <= 5) {
                // Sub-Category (Use an existing main category's ID as parent)
                if ($mainCategory) {
                    $attributes['parent_id'] = $mainCategory->id;
                }
            } else {
                // Sub-Child Category (Use an existing sub-category's ID as parent)
                if ($subCategory) {
                    $attributes['parent_id'] = $subCategory->id;
                }
            }
            return $attributes;
        }
    }
}
