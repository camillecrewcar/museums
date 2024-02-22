<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;

use App\Models\Likes;

class LikesController extends Controller
{
    public function like(Request $request)
    {
        $commentId = $request->input('commentId');
        $userId = auth()->user()->id;

        // Check if the user has already liked or disliked the comment
        $like = Likes::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            // User has already liked or disliked the comment, so update the like
            $like->isPositive = true;
            $like->save();
        } else {
            // User has not liked or disliked the comment, so create a new like
            $like = new Likes();
            $like->comment_id = $commentId;
            $like->user_id = $userId;
            $like->isPositive = true;
            $like->save();
        }

        // Return the updated like count for the specific comment
        $likeCount = Comments::find($commentId)
            ->like()
            ->where('isPositive', true)
            ->count();

        return response()->json([
            'likeCount' => $likeCount,
        ]);
    }

    public function unlike(Request $request)
    {
        $commentId = $request->input('commentId');
        $userId = auth()->user()->id;

        // Find the like record for the comment by the user
        $like = Likes::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            // Remove the like
            $like->delete();
        }

        // Return the updated like count for the specific comment
        $likeCount = Comments::find($commentId)
            ->like()
            ->where('isPositive', true)
            ->count();

        return response()->json([
            'likeCount' => $likeCount,
        ]);
    }

    public function dislike(Request $request)
    {
        $commentId = $request->input('commentId');
        $userId = auth()->user()->id;

        // Check if the user has already disliked the comment
        $like = Likes::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->isPositive = false;
            $like->save();
        } else {
            // User has not disliked the comment, so create a new dislike
            $like = new Likes();
            $like->comment_id = $commentId;
            $like->user_id = $userId;
            $like->isPositive = false;
            $like->save();
        }

        // Return the updated dislike count
        $dislikeCount = Comments::find($commentId)
            ->like()
            ->where('isPositive', false)
            ->count();

        return response()->json([
            'dislikeCount' => $dislikeCount,
        ]);
    }

    public function undislike(Request $request)
    {
        $commentId = $request->input('commentId');
        $userId = auth()->user()->id;

        // Find the dislike record for the comment by the user
        $like = Likes::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            // Remove the dislike
            $like->delete();
        }

        // Return the updated dislike count
        $dislikeCount = Comments::find($commentId)
            ->like()
            ->where('isPositive', false)
            ->count();

        return response()->json([
            'dislikeCount' => $dislikeCount,
        ]);
    }
}
