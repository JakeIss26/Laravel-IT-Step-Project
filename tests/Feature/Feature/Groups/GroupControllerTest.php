<?php

namespace Tests\Feature\Feature\Groups;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Group;

class GroupControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function test_group_index(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/group');

        $response->assertStatus(200);
    }

    public function test_group_show(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/group');

        $group = Group::factory()->create();
        
        $response = $this->get('/api/group/' . $group->id);

        $response->assertStatus(200);
    }

    public function test_group_update(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $group = Group::factory()->create(['owner' => $user->id]);

        $newPostData = [
            'owner' =>User::factory()->create()->id,
            'description' => $this->faker->sentence
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/group/{$group->id}", $newPostData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'owner' => $newPostData['owner'],
            'description' => $newPostData['description']
        ]);
    }

    public function test_group_destroy(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $group = Group::factory()->create(['owner' => $user->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/group/{$group->id}");

        $response->assertStatus(204);
        // $this->assertDeleted('posts', ['id' => $post->id]);
    }
}
