<?php

namespace Tests\Feature\Images;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Photo;

class ImageControllerTest extends TestCase
{

    // public function test_getPhotosByPostId(): void
    // {

    //     $user = User::factory()->create();
    //     $token = JWTAuth::fromUser($user);

    //     $post = Post::factory()->create();
    //     $photo = Photo::factory()->create(['post_id' => $post->id]);

    //     $response = $this->get("api/image/getPhotos/{$post->id}");

    //     $response->assertStatus(200)
    //              ->assertJson([$photo->toArray()]);
    // }

}
