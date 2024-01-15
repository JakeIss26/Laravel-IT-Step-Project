<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $postsCount = $user->posts()->count();
        $followers = $user->followers()->count();
        $subscriptions = $user->subscriptions()->count();
        // dd($user, $user->posts());

        return response()->json([
            'id' => $user->id,
            'login' => $user->login,
            'birth_date' => $user->birth_date,
            'name' => $user->name,
            'email' => $user->email,
            'avatar_path' => $user->avatar_path,
            'posts' => $postsCount,
            'followers' => $followers,
            'subscriptions' => $subscriptions,
            // Добавьте другие необходимые поля
        ]);
        // $users = User::all();
        // return response()->json($users);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    public function showCurrentUserData(string $id)
    {
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
