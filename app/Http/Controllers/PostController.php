<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function showPosts() {
        $posts = Post::all();
        return $posts;
    }

    public function getById($id) {
        $post = Post::find($id);
        return $post;
    }

    public function addPost(Request $request) {
        $post = new Post();
        $post->name = $request->name;
        $post->user_id = $request->user_id;
        $post->publication_time = $request->publication_time;
        $post->save();

        return $post;
    }

    public function removePost($id) {
        $post = Post::find($id);
        $post->delete();

        return response('Delete successfully', 204);
    }

    public function updatePost(Request $request, $postId) {
        $post = Post::find($postId);
        $post->update([
            'name' => $request->input('name', $post->name),
            'user_id' => $request->input('user_id', $post->user_id),
            'publication_time' => $request->input('publication_time', $post->publication_time),
        ]);

        return $post;
    }
}
