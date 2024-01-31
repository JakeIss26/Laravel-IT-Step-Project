<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'login' => $this->faker->unique()->userName,
            'password' => substr(preg_replace('/[^A-Za-z0-9]/', '', $this->faker->password(20)), 0, 20),
            'birth_date' => $this->faker->date(),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'created_at' => now(),
            'updated_at' => now(),
            'avatar_path' => 'path/to/photos/' . $this->faker->word . '.jpg',
        ];
    }
}