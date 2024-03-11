<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class ImageFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'publication_time' => now(),
            'image_path' => $this->faker->imageUrl(),
            'post_id' => function () {
                return Post::factory()->create()->id;
            },
        ];
    }
}
