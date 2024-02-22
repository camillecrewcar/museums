<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:1000'
        ]);

        $comment = new Comments();
        $comment->thread_id = $request->input('thread_id');
        $comment->user_id = Auth::id();
        $comment->description = $request->input('description');
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully');
    }

    public static function getCommentLikesCount($commentId)
    {
        $comment = Comments::find($commentId);
        if ($comment) {
            return $comment->likes->count();
        }
        return 0;
    }
}
