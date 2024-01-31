<?php

namespace Tests\Feature\Http\Controllers\Posts;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostControllerTest extends TestCase
{

    use DatabaseTransactions, WithFaker;

    public function test_post_index(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/post');

        $response->assertStatus(200);
    }

    public function test_post_show(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/post');

        $post = Post::factory()->create();
        
        $response = $this->get('/api/post/' . $post->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'user_id',
                'publication_time'
        ]);
    }

    public function test_post_store(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $post = Post::factory()->make()->toArray();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/post', $post);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'user_id',
                'publication_time'
        ]);
    }

    public function test_post_update(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $newPostData = [
            'name' => $this->faker->sentence
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/post/{$post->id}", $newPostData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'name' => $newPostData['name']
        ]);
    }

    public function test_post_destroy(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/post/{$post->id}");

        $response->assertStatus(204);
        // $this->assertDeleted('posts', ['id' => $post->id]);
    }
}
