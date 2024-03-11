<?php

namespace Tests\Feature\Http\Controllers\Comments;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function test_comment_index(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/comment');

        $response->assertStatus(200);
    }

    public function test_comment_show(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/comment');

        $comment = Comment::factory()->create();
        
        $response = $this->get('/api/comment/' . $comment->id);

        $response->assertStatus(200);
    }

    public function test_comment_store(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $post = Post::factory()->create();

        $comment = Comment::factory()->make()->toArray();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/comment', $comment);

        $response->assertStatus(201);
    }

    public function test_comment_update(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $comment = Comment::factory()->create(['author_id' => $user->id]);

        $newPostData = [
            'description' => $this->faker->sentence
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/comment/{$comment->id}", $newPostData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'description' => $newPostData['description']
        ]);
    }

    public function test_comment_destroy(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $comment = Comment::factory()->create(['author_id' => $user->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/comment/{$comment->id}");

        $response->assertStatus(204);
        // $this->assertDeleted('posts', ['id' => $post->id]);
    }

    public function test_comment_store_invalid_post_id(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $commentData = [
            'description' => $this->faker->sentence,
            'author_id' => $user->id,
            'post_id' => -1 // Invalid post ID
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/comment', $commentData);

        $response->assertStatus(404);
    }

    public function test_comment_update_not_owned_by_user(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $comment = Comment::factory()->create(); // Comment not owned by the user

        $newCommentData = [
            'description' => $this->faker->sentence
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/comment/{$comment->id}", $newCommentData);

        $response->assertStatus(403);
    }

    public function test_comment_update_invalid_comment_id(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $newCommentData = [
            'description' => $this->faker->sentence
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/comment/-1", $newCommentData); // Invalid comment ID

        $response->assertStatus(404);
    }

    public function test_comment_destroy_not_owned_by_user(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $comment = Comment::factory()->create(); // Comment not owned by the user

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/comment/{$comment->id}");

        $response->assertStatus(403);
    }

    public function test_comment_destroy_invalid_comment_id(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/comment/-1"); // Invalid comment ID

        $response->assertStatus(404);
    }

    public function test_comment_show_invalid_comment_id(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/comment/-1'); // Invalid comment ID

        $response->assertStatus(404);
    }
}
