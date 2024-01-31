<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'post_id' => $this->faker->numberBetween(1, 100), // Пример случайного выбора id поста
            'author_id' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence, // Пример случайного выбора id автора
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
