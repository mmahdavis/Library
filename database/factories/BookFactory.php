<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Publisher;
use App\Models\Tag;
use App\Models\Translator;
use App\Models\Writer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
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
            'writer_id' => Writer::inRandomOrder()->first(),
            'publisher_id' => Publisher::inRandomOrder()->first(),
            'translator_id' => Translator::inRandomOrder()->first(),
            'code' => $this->faker->unique()->ean8(),
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(6, true),
            'image' => 'https://fakeimg.pl/320/',
        ];
    }
}
