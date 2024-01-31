<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'publication_time' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
