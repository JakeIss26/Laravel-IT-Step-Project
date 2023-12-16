<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post; 

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->author_id = $request->author_id;
        $comment->save();

        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('comments')->find($id);
        return $post->comments;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
        $comment->update([
            'post_id' => $request->input('post_id', $comment->post_id),
            'author_id' => $request->input('author_id', $comment->author_id),
        ]);

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response('Delete successfully', 204);
    }
}
