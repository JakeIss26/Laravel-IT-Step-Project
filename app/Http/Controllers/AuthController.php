<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid login or password'], 401);
        }

        return response()->json(['access_token' => $token], 200);
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate();

        return response()->json(['message' => 'Logout successful'], 200);
    }
    
}
