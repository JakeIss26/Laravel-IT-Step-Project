<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class UserService {

    public function registerUser($data) {
        $existingUser = User::where('email', $data['email'])->orWhere('login', $data['login'])->first();
    
        if ($existingUser) {
            return response()->json(['error' => 'User with this email or login already exists'], 422);
        }

        $user = User::create($data);
    
        return $user;
    }
    
    public function loginUser($data) {
        if (!$token = JWTAuth::attempt($data)) {
            return response()->json(['error' => 'Invalid login credentials'], 401);
        }
        
        return $token;
    }

    public function logoutUser() {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);
        
        return response()->json(['message' => 'Logout successful'], 200);
    }
}