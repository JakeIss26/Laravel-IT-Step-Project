<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService {


    public function getPosts($number) {
        $posts = Post::paginate($number);
        return $posts;
    }

    public function showPost(string $id) {
        $post = Post::findOrFail($id);
        return $post;
    }

    public function addPost($data, $user) {
        $data['user_id'] = $user->id;
        $post = Post::create($data);
        return $post;
    }

    public function deletePost(string $id) {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Delete successfully'], 200);
    }

    public function updatePost($data, $user, string $id) {
        $post = Post::findOrFail($id);
        $data['user_id'] = $user->id;
        $post->update($data);

        return $post;
    }
}