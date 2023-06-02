<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Twitter>
 */
class TwitterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->text(),
            "user_name" => fake()->name(),
            'retweet_count' => rand(0, 999),
            'image' => fake()->imageUrl(),
            "user_avatar" => fake()->imageUrl()
        ];
    }
}
