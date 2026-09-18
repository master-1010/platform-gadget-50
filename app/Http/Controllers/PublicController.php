<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    public function home()
    {
        $posts = Post::query()
            ->with(['category', 'user'])
            ->where('status', 'approved')
            ->latest('published_at')
            ->paginate(12);

        return view('home', compact('posts'));
    }

    public function show(Post $post)
    {
        abort_unless($post->status === 'approved', 404);

        $post->increment('views');

        return view('posts.show', compact('post'));
    }

    public function category(Category $category)
    {
        $posts = $category->posts()
            ->where('status', 'approved')
            ->latest('published_at')
            ->paginate(12);

        return view('category', compact('category', 'posts'));
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->query('q', ''));

        $posts = Post::query()
            ->with(['category', 'user'])
            ->where('status', 'approved')
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%")
                        ->orWhere('excerpt', 'like', "%{$query}%");
                });
            })
            ->latest('published_at')
            ->paginate(12)
            ->appends(['q' => $query]);

        return view('search', compact('posts', 'query'));
    }

    public function like(Request $request, Post $post)
    {
        $token = hash('sha256', $request->ip() . '|' . ($request->userAgent() ?? ''));

        if (! $post->likes()->where('token', $token)->exists()) {
            $post->likes()->create(['token' => $token]);
            $post->increment('likes_count');
        }

        return back();
    }

    public function comment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $post->comments()->create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'body' => $validated['body'],
            'user_id' => $request->user()?->id,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Comment submitted for moderation.');
    }
}
