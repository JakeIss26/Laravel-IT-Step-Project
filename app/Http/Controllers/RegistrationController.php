<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegistrationController extends Controller
{
    public function register(Request $request) 
    {

        $validated = $request->validate([
            'login' => [
                'required',
                'min:3',
                'max:50'
            ],
            'password' => [
                'required',
                'min:6',
                'max:20',
                'alpha_num'
            ],
            'birth_date' => [
                'nullable',
                'min:8',
                'max:20'
            ],
            'name' => [
                'required',
                'min:3',
                'max:50'
            ],
            'email' => [
                'required',
                'min:6',
                'max:50'
            ]
        ]);
        $user = new User();
        $user->login = $validated['login'];
        $user->password = Hash::make($validated['password']);
        $user->birth_date = $validated['birth_date'];
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'access_token' => $token], 200);

        // return redirect('/login');
    }
}
