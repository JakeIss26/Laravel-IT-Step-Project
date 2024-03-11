<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        // Apply the 'jwt.auth' middleware to all methods in this controller
        $this->middleware('jwt.auth');
    }

    // public function index() {
    //     $posts = Post::all();
    //     return response()->json($posts);
    // }
    public function index() {
        $posts = Post::paginate(10); // Пагинируем результаты, 10 постов на страницу
        return response()->json($posts);
    }

    public function show(string $id, ) {
        $user = Auth::user();
        $post = Post::find($id);
        return $post;
    }

    public function store(Request $request) {
        $user = Auth::user();
        $post = new Post();
        $post->name = $request->name;
        $post->user_id = $user->id;
        $post->publication_time = now();
        $post->save();
        return $post->id;
    }

    public function destroy(Request $request, string $id) {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        if ($post->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $post->delete();

        return response('Delete successfully', 204);
    }

    public function update(Request $request, string $id) {
        $post = Post::find($id);

        if ($post->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $post->update([
            'name' => $request->input('name', $post->name),
            'user_id' => $request->input('user_id', $post->user_id),
            'publication_time' => $request->input('publication_time', $post->publication_time),
        ]);

        return $post;
    }
}
