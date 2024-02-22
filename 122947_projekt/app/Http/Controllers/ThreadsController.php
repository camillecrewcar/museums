<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;
use App\Models\Threads;
use App\Models\Likes;
use App\Models\TagsThreads;
use App\Models\Tags;
use Illuminate\Support\Facades\Auth;


class ThreadsController extends Controller
{
    public function index($id)
    {
        // Retrieve the thread based on the provided $id
        $thread = Threads::findOrFail($id);
        $comments = $thread->comments;

        // Retrieve the user's like/dislike status for each comment if logged in
        $user = auth()->user();

        $likes = Likes::all();
        $likesJson = $likes->toJson();

        $tags = $thread->tags;
        $tag = Tags::all();
        $cities = Cities::all();

        return view('threads.index', compact('thread', 'comments', 'likes', 'likesJson', 'tags', 'cities','tag'));
    }


    public function store(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tags' => 'required',
        ]);

        // Process tags
        $tagNames = explode(',', $validatedData['tags']);
        $tags = [];

        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);

            // Check if the tag already exists
            $tag = Tags::where('name', $tagName)->first();

            if (!$tag) {
                // Tag does not exist, create a new one
                $tag = new Tags;
                $tag->name = $tagName;
                $tag->save();
            }

            $tags[] = $tag->id;
        }

        // Create a new thread
        $thread = new Threads;
        $thread->title = $validatedData['title'];
        $thread->description = $validatedData['description'];
        $thread->user_id = Auth::id();
        $thread->save();

        // Attach the tags to the thread
        foreach ($tags as $tagId) {
            $tagThread = new TagsThreads;
            $tagThread->tag_id = $tagId;
            $tagThread->thread_id = $thread->id;
            $tagThread->save();
        }

        // Redirect or perform any additional actions as needed
        return redirect()->route('threads.index', ['id' => $thread->id]);
    }
    public function destroy($id)
    {
        // Find the thread by ID
        $thread = Threads::findOrFail($id);

        // Check if the authenticated user is authorized to delete the thread
        // You can replace this with your own authorization logic
        if (!auth()->user()->role === 1) {
            return redirect()->back()->with('error', 'You are not authorized to delete this thread.');
        }

        // Delete the thread
        $thread->delete();

        // Redirect the user to the threads index page
        return redirect()->route('root')->with('success', 'Thread deleted successfully.');
    }

}

