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

        $response->assertStatus(200);
        //     ->assertJsonStructure([
        //         'id'
        // ]);
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

    public function test_post_index_returns_correct_data_structure()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/post');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'user_id',
                    'publication_time'
                ]
            ]);
    }

    public function test_post_index_with_pagination()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/post?page=2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'user_id',
                    'publication_time'
                ]
            ]);
    }

    public function test_post_show_returns_correct_data_structure()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $post = Post::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/post/' . $post->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'user_id',
                'publication_time'
            ]);
    }

    public function test_post_update_owned_by_user()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        // Создание поста, который не принадлежит пользователю
        $post = Post::factory()->create();
    
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/post/{$post->id}", ['name' => 'New Name']);
    
        $response->assertStatus(403);
    }

    public function test_post_destroy_owned_by_user()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $post = Post::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/post/{$post->id}");

        $response->assertStatus(403);
    }

    public function test_post_destroy_invalid_id()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/post/1826");

        $response->assertStatus(404);
    }
}
