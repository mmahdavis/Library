<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpecialIssue>
 */
class SpecialIssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first(),
            'tag_id' => Tag::inRandomOrder()->first(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->unique()->slug(1),
            'price' => $this->faker->randomNumber(6, true),
        ];
    }
}
