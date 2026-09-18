<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts()->with('category')->latest()->paginate(15);

        return view('dashboard.posts', compact('posts'));
    }

    public function create()
    {
        return view('dashboard.posts-form', [
            'post' => new Post(),
            'categories' => Category::query()->where('active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string', 'max:150000'],
            'external_image_url' => ['nullable', 'url:http,https', 'max:2000'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'anonymous' => ['boolean'],
        ]);

        $slug = Str::slug($validated['title']) ?: 'post';
        $slug .= '-' . Str::lower(Str::random(6));

        $postData = [
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'anonymous' => $request->boolean('anonymous'),
            'status' => 'pending',
            'slug' => $slug,
            'external_image_url' => $validated['external_image_url'] ?? null,
        ];

        if ($request->hasFile('featured_image')) {
            $postData['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post = Auth::user()->posts()->create($postData);

        return redirect()->route('dashboard.posts.index')->with('status', 'Post submitted for moderation.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('dashboard.posts-form', [
            'post' => $post,
            'categories' => Category::query()->where('active', true)->get(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string', 'max:150000'],
        ]);

        $post->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard.posts.index')->with('status', 'Post updated and resubmitted for moderation.');
    }
}
