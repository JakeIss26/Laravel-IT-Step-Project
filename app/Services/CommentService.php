<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentService {


    // 1. Сначала надо сделать реквесты через php artisan make:request для каждого метода каждого контроллера
    // 2. Потом надо создать все сервисы и каждый метод контроллера добавить в сервис для этого контроллера
    // 3. 

    public function getComments() {
        $comments = Comment::all();
        return $comments;
    }

    public function showComment(string $id) {
        $comment = Comment::find($id);

        // if (!$comment) {
        //     return response()->json(['message' => 'Comment not found'], 404);
        // }

        $post = Post::with('comments')->find($id);
        return $post;
    }

    public function addComment($data) {

        $post = Post::find($request->post_id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $comment = new Comment();

        

        $comment->post_id = $request->post_id;
        $comment->author_id = $request->author_id;
        $comment->save();

        return $comment;

        $comment = new Comment();
        $comment->create($data);
        return $comment;
    }

    public function deleteComment(string $id) {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['response' => 'Deleted'], 200);
    }

    public function updateComment($data, string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($data);

        return $comment;
    }
}