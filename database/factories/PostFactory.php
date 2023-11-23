<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence;
        $slug = Str::slug($title,"-");
        return [
            //
            'user_id' => fake()->numberBetween(1,10),
            'title' => $title,
            'slug' => $slug,
            'excerpt' => fake()->sentence,
            'description' => fake()->paragraph,
            // 'is_published' => false,
            'min_to_read' => fake()->numberBetween(10,20),
        ];
    }
}
