<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::query()->with(['post', 'user'])->latest()->paginate(20);

        return view('admin.comments', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('status', 'Comment approved.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return back()->with('status', 'Comment rejected.');
    }
}
