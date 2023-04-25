<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Magazine>
 */
class MagazineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => 'https://fakeimg.pl/320/',
            'name' => $this->faker->name(),
            'slug' => $this->faker->unique()->slug(1),
            'price' => $this->faker->randomNumber(6, true),
        ];
    }
}
