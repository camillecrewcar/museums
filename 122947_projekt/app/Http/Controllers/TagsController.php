<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;
use App\Models\Tags;
use App\Models\Threads;

class TagsController extends Controller
{
    public function index($id = null)
    {
        $tags = Tags::all();
        // wyszukanie 12 najpopularniejszych tagów
        $tagsWithMostThreads = Tags::withCount('threads')
            ->orderBy('threads_count', 'desc')
            ->limit(12)
            ->get();
        $cities = Cities::all();

        //rozpoznanie czy id jest podane czy nie
        if ($id) {
            $selectedTag = Tags::findOrFail($id);
            $threads = $selectedTag->threads;
        } else {
            $selectedTag = null;
            $threads = Threads::latest()->get();
        }

        return view('welcome', [
            'tags' => $tagsWithMostThreads,
            'tag' => $tags,
            'threads' => $threads,
            'cities' => $cities,
            'selectedTag' => $selectedTag,
        ]);
    }

    public function search(Request $request)
    {
        $tags = Tags::all();
        $selectedTag = $request->input('tag');
        $threads = Threads::whereHas('tags', function ($query) use ($selectedTag) {
            $query->where('name', $selectedTag);
        })->get();
        $tagsWithMostThreads = Tags::withCount('threads')
            ->orderBy('threads_count', 'desc')
            ->limit(12)
            ->get();
        $cities = Cities::all();

        // Find the selected tag record
        $tag = $tags->firstWhere('name', $selectedTag);

        return view('welcome', [
            'tags' => $tagsWithMostThreads,
            'tag' => $tags,
            'threads' => $threads,
            'cities' => $cities,
            'selectedTag' => $tag,
        ]);
    }
}
