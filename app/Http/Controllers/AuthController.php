<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Token;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('login', $request->login)->where('password', $request->password)->first();

        if ($user) {
            $token = new Token();
            $token->token = $user->generateToken();
            $token->login = $request->login;
            $token->save();

            return $token;
        }


    }

    public function logout(Request $request)
    {

    }
    
}
