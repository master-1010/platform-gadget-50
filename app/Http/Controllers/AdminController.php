<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::query()->count(),
            'posts' => Post::query()->count(),
            'pending' => Post::query()->where('status', 'pending')->count(),
            'approved' => Post::query()->where('status', 'approved')->count(),
            'rejected' => Post::query()->where('status', 'rejected')->count(),
            'comments' => Comment::query()->count(),
            'views' => Post::query()->sum('views'),
            'likes' => Post::query()->sum('likes_count'),
        ];

        return view('admin.index', compact('stats'));
    }

    public function posts(Request $request)
    {
        $status = $request->query('status');

        $posts = Post::query()
            ->with(['user', 'category'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20);

        return view('admin.posts', compact('posts', 'status'));
    }

    public function approve(Post $post)
    {
        $this->authorize('approve', $post);

        $post->update([
            'status' => 'approved',
            'published_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('status', 'Post approved.');
    }

    public function reject(Request $request, Post $post)
    {
        $this->authorize('reject', $post);

        $request->validate([
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $post->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('reason'),
        ]);

        return back()->with('status', 'Post rejected.');
    }

    public function categories()
    {
        return view('admin.categories', [
            'categories' => Category::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function storeCategory(Request $request)
    {
        $this->authorize('create', Category::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Category::query()->create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => Category::query()->max('sort_order') + 1,
        ]);

        return back()->with('status', 'Category created.');
    }
}
