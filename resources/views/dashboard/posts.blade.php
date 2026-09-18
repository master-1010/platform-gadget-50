@extends('layouts.app')

@section('content')
<div class="bg-white border rounded-xl p-6 shadow-sm">
    <h1 class="text-3xl font-black mb-4">My posts</h1>

    <div class="space-y-3">
        @forelse($posts as $post)
            <div class="border rounded p-4 flex items-center justify-between">
                <div>
                    <div class="font-bold">{{ $post->title }}</div>
                    <div class="text-sm text-slate-500">{{ $post->status }}</div>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('dashboard.posts.edit', $post) }}" class="text-blue-700">Edit</a>
                </div>
            </div>
        @empty
            <p class="text-slate-500">No posts yet.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $posts->links() }}</div>
</div>
@endsection
