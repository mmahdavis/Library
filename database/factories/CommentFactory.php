<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public $id = [1, 2, 3, 4, 5];
    public $type = ['Book', 'SpecialIssue', 'Magazine'];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::first(),
            'entity_id' => $this->id[array_rand($this->id)],
            'type' => $this->type[array_rand($this->type)],
            'message' => $this->faker->realText(),
        ];
    }
}
