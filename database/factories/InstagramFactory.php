<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instagram>
 */
class InstagramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'title' => fake()->title(),
           'images_gallery' => $this->makeGallery(4),
           'video_gallery' => $this->makeGallery(4),
           "content" => fake()->text(250),
           "user_name" => fake()->name(),
           "user_avatar" => fake()->image(),
           "user_username" => fake()->userName()
        ];
    }

    private function makeGallery(int $imagesCount)
    {
        $images = [];
        for ($i = 0; $i < $imagesCount; $i++) {
            $images[] = fake()->imageUrl();
        }

        return $images;
    }
}
