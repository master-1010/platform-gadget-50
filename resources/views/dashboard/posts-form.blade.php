@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white border rounded-xl p-6 shadow-sm">
    <h1 class="text-3xl font-black mb-4">{{ $post->exists ? 'Edit post' : 'Create post' }}</h1>

    <form method="POST" action="{{ $post->exists ? route('dashboard.posts.update', $post) : route('dashboard.posts.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @if($post->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input name="title" value="{{ old('title', $post->title) }}" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Category</label>
            <select name="category_id" required class="w-full border rounded px-3 py-2">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Excerpt</label>
            <textarea name="excerpt" rows="3" class="w-full border rounded px-3 py-2">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Content</label>
            <textarea name="content" rows="12" required class="w-full border rounded px-3 py-2">{{ old('content', $post->content) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Featured image</label>
            <input type="file" name="featured_image" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">External image URL</label>
            <input type="url" name="external_image_url" value="{{ old('external_image_url', $post->external_image_url) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="anonymous" value="1" {{ old('anonymous', $post->anonymous) ? 'checked' : '' }} />
            Publish anonymously
        </label>

        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">{{ $post->exists ? 'Update post' : 'Submit post' }}</button>
    </form>
</div>
@endsection
