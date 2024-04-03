<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Services\CommentService;
use App\Http\Requests\CommentRequest;
use App\Models\Post; 
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    protected $commentService;

    public function __construct()
    {
        
        $this->groupService = new CommentService();
        $this->user = Auth::user();
        // Apply the 'jwt.auth' middleware to all methods in this controller
        $this->middleware('jwt.auth');
    }

    public function index() {
        $comments = $this->commentService->getComments();
        return $comments;
    }
    
    public function show(string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $post = Post::with('comments')->find($id);
        return $post;
    }

    public function store(Request $request)
    {
        $post = Post::find($request->post_id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->author_id = $request->author_id;
        $comment->save();

        return $comment;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        if ($comment->author_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

    
        $comment->update([
            'post_id' => $request->input('post_id', $comment->post_id),
            'author_id' => $request->input('author_id', $comment->author_id),
            'description' => $request->input('description', $comment->description),
        ]);
    
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        if ($comment->author_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }


        $comment = Comment::find($id);
        $comment->delete();

        return response('Delete successfully', 204);
    }
}
