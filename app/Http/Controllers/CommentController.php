<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\PostComment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseController
{
    /**
     * Store a newly created comment.
     */
    public function store(CommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);

        return $this->sendResponse(new CommentResource($comment), "Comment added successfully", 201);
    }

    /**
     * Update an existing comment.
     */
    public function update(CommentRequest $request, PostComment $comment)
    {
        $comment->update([
            'body' => $request->body
        ]);

        return $this->sendResponse(new CommentResource($comment), "Comment updated successfully");
    }

    /**
     * Delete a comment.
     */
    public function destroy(PostComment $comment)
    {
        $status = $comment->delete();

        return $this->sendResponse(null, "Comment deleted successfully", $status ? 200 : 500);
    }

    /**
     * Like/Unlike a comment.
     */
    public function likeComment(PostComment $comment)
    {
        $user = Auth::id();

        if ($comment->likes()->where('user_id', $user)->exists()) {
            $comment->likes()->where('user_id', $user)->delete();
            return $this->sendResponse(null, "Comment unliked");
        }

        $comment->likes()->create(['user_id' => $user]);

        return $this->sendResponse(null, "Comment liked");
    }

    /**
     * Reply to a comment.
     */
    public function replyComment(CommentRequest $request, PostComment $comment)
    {
        $reply = $comment->replies()->create([
            'user_id' => Auth::id(),
            'comment_id' => $comment->id,
            'post_id' => $comment->post_id,
            'body' => $request->body
        ]);

        return $this->sendResponse(new CommentResource($reply), "Reply added successfully", 201);
    }
}
