<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class RegistrationController extends Controller
{

    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function register(RegistrationRequest $request) 
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = $this->userService->registerUser($data);
        return $user;
    }
}
