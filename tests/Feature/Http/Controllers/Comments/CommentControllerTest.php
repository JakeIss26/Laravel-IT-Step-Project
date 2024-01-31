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
}
