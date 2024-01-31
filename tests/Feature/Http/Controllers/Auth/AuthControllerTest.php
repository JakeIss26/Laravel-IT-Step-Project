<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_registration()
    {
        $userData = User::factory()->make()->toArray();

        $response = $this->post('/api/user/register', $userData);

        $response->assertStatus(201);
    }

    public function test_user_login()
    {
        $userData = [
            "login" => "Jul",
            "password" => "1234abcd"
        ];

        $response = $this->post('/api/user/login', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
            ]); // Assuming successful login returns a 200 status code
        // Add additional assertions based on your login logic
    }
}
