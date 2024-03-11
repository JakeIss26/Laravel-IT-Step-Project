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

    public function test_group_store(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $group = Group::factory()->make()->toArray();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/group', $group);

        $response->assertStatus(201);
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

    // public function test_group_store_missing_owner(): void
    // {
    //     // Создаем пользователя и получаем токен
    //     $user = User::factory()->create();
    //     $token = JWTAuth::fromUser($user);
    
    //     // Создаем группу без указания owner
    //     $group = Group::factory()->make(['owner' => null])->toArray();
    
    //     // Отправляем запрос на создание группы
    //     $response = $this->withHeader('Authorization', 'Bearer ' . $token)
    //         ->post('/api/group', $group);
    
    //     // Проверяем, что сервер вернул код ошибки 422
    //     $response->assertStatus(422);
    // }
    
    // public function test_group_store_invalid_owner(): void
    // {
    //     // Создаем пользователя и получаем токен
    //     $user = User::factory()->create();
    //     $token = JWTAuth::fromUser($user);
    
    //     // Создаем группу с недопустимым значением owner
    //     $group = Group::factory()->make(['owner' => 999])->toArray();
    
    //     // Отправляем запрос на создание группы
    //     $response = $this->withHeader('Authorization', 'Bearer ' . $token)
    //         ->post('/api/group', $group);
    
    //     // Проверяем, что сервер вернул код ошибки 422 и правильное сообщение об ошибке
    //     $response->assertStatus(422)
    //         ->assertJson([
    //             'error' => 'Invalid owner.'
    //         ]);
    // }
    

    public function test_group_update_invalid_owner(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        $group = Group::factory()->create(['owner' => $user->id]);
    
        $newGroupData = [
            'owner' => -1,
            'description' => $this->faker->sentence
        ];
    
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/group/{$group->id}", $newGroupData);
    
        $response->assertStatus(422)
            ->assertJson(['message' => 'Invalid owner']);
    }

    public function test_group_update_missing_owner(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        $group = Group::factory()->create(['owner' => $user->id]);
    
        $newGroupData = [
            'owner' => null,
            'description' => $this->faker->sentence
        ];
    
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/group/{$group->id}", $newGroupData);
    
        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Invalid owner']);
    }

    public function test_group_update_not_owned_by_user(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $group = Group::factory()->create();

        $newGroupData = [
            'owner' => User::factory()->create()->id,
            'description' => $this->faker->sentence
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/group/{$group->id}", $newGroupData);

        $response->assertStatus(403);
    }

    public function test_group_update_missing_description(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        $group = Group::factory()->create(['owner' => $user->id]);
    
        $newGroupData = [
            'owner' => $user->id,
            'description' => null,
        ];
    
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->put("/api/group/{$group->id}", $newGroupData);
    
        $response->assertStatus(422)
            ->assertJson(['message' => 'The description field is required.']);
    }

    public function test_group_destroy_not_owned_by_user(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $group = Group::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/group/{$group->id}");

        $response->assertStatus(403);
    }

    public function test_group_destroy_invalid_id(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("/api/group/9999");

        $response->assertStatus(404);
    }
}
