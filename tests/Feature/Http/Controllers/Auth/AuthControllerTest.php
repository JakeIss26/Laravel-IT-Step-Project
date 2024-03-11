<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;
use Illuminate\Support\Str;
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

    public function test_user_registration_with_incorrect_data()
    {
        $userData = [
            'login' => '',
            'password' => '',
            'name' => '',
            'email' => '',
            'avatar_path' => '',
        ];
    
        $response = $this->post('/api/user/register', $userData);
    
        $response->assertStatus(302) // Утверждаем, что произошло перенаправление
                 ->assertSessionHasErrors(['login', 'password', 'name', 'email', 'avatar_path']); // Утверждаем, что в сессии есть ошибки валидации для указанных полей
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

    public function test_user_login_with_incorrect_credentials()
    {
        $userCredentials = [
            "login" => "nonexistent_user",
            "password" => "incorrect_password"
        ];

        $response = $this->post('/api/user/login', $userCredentials);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Invalid login or password'
            ]);
    }

    public function test_user_login_with_empty_credentials()
    {
        $userData = [
            "login" => "", // Пустое значение для login
            "password" => "", // Пустое значение для password
        ];
    
        $response = $this->post('/api/user/login', $userData);
    
        $response->assertStatus(302) // Ожидаем перенаправление
            ->assertSessionHasErrors(['login', 'password']); // Проверяем наличие ошибок в сессии для полей login и password
    }

    public function test_user_logout()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/user/logout');

        $response->assertStatus(200);

        $this->assertFalse(JWTAuth::check());
    }

    public function test_access_protected_resource_without_authentication()
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/post');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Token not provided',
            ]);
    }

    // public function test_user_can_delete_account()
    // {
    //     $user = User::factory()->create();
        
    //     $this->actingAs($user);
        
    //     $response = $this->delete('/api/user/delete-account');
        
    //     $response->assertStatus(200)
    //              ->assertJson([
    //                  'message' => 'Account deleted successfully',
    //              ]);
    // }

}
