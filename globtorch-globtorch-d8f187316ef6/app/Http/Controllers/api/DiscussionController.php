<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Discussion;
use App\Comment;

class DiscussionController extends Controller
{
    public function index($subject_id)
    {
        $discussions = Discussion::where('subject_id', $subject_id)->get();
        return response()->json($discussions, 200);
    }

    public function store(Request $request, $subject_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
        ]);

        $discussion = new Discussion;
        $discussion->title = $request->input('title');
        $discussion->body = $request->input('body');
        $discussion->subject_id = $subject_id;
        $discussion->user_id = Auth::id();
        $discussion->save();

        return response()->json(['message'=>'Successfully created discussion'], 200);
    }

    public function show($id)
    {
        $discussion = Discussion::with('comments.user')->findOrFail($id);
        return response()->json($discussion, 200);
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|max:255',
        ]);

        $comment = new Comment;
        $comment->comment = $request->input('comment');
        $comment->discussion_id = $id;
        $comment->user_id = Auth::id();
        $comment->save();

        return response()->json(['message'=>'Successfully added comment'], 200);
    }
}
