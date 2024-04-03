<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Http\Requests\AuthorizationRequest;

class AuthController extends Controller
{

    public function __construct()
    {
        
        $this->userService = new UserService();
    }

    public function login(AuthorizationRequest $request)
    {
        $data = $request->all();
        $token = $this->userService->loginUser($data);

        return $token;
    }
    

    public function logout(Request $request)
    {
        $response = $this->userService->logoutUser();
        return $response;
    }
}
