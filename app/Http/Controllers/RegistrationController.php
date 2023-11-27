<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                'alpha_num:ascii'
            ],
            'birth_date' => [
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
                'max:50',
                'email:rfc,dns'
            ]
        ]);
        $user = new User();
        $user->login = $validated['login'];
        $user->password = $validated['password'];
        $user->birth_date = $validated['birth_date'];
        $user->name = $validated['name'];
        $user->email = Hash::make($validated['email']);
        $user->save();

        return $user;
        // return redirect('/login');
    }
}
