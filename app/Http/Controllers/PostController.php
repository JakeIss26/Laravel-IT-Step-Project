<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Services\PostService;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    protected $postService;

    public function __construct()
    {
        
        $this->postService = new PostService();
        $this->middleware('jwt.auth');
    }

    public function index() {
        $number = 5;
        $posts = $this->postService->getPosts($number);
        return $posts;
    }

    public function show(string $id) {
        $post = $this->postService->showPost($id);
        return $post;
    }

    public function store(PostRequest $request) {
        $user = Auth::user();
        $data = $request->all();

        $post = $this->postService->addPost($data, $user);

        return $post;
    }

    public function destroy(string $id) {
        $response = $this->postService->deletePost($id);
        return $response;
    }

    public function update(PostRequest $request, string $id) {
        $user = Auth::user();
        $data = $request->all();
        
        $post = $this->postService->updatePost($data, $user, $id);

        return $post;
    }
}
