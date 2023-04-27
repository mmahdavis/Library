<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' => User::inRandomOrder()->first(),
            'type' => $this->faker->randomElement(['danger', 'info', 'success', 'warning']),
            'title' => $this->faker->sentence(2, true),
            'message' => $this->faker->paragraph(),
        ];
    }
}
