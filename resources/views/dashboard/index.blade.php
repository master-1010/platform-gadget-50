@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <div class="text-sm text-slate-500">Total posts</div>
            <div class="text-3xl font-black mt-2">{{ auth()->user()->posts()->count() }}</div>
        </div>
        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <div class="text-sm text-slate-500">Pending</div>
            <div class="text-3xl font-black mt-2">{{ auth()->user()->posts()->where('status', 'pending')->count() }}</div>
        </div>
        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <div class="text-sm text-slate-500">Approved</div>
            <div class="text-3xl font-black mt-2">{{ auth()->user()->posts()->where('status', 'approved')->count() }}</div>
        </div>
        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <div class="text-sm text-slate-500">Views</div>
            <div class="text-3xl font-black mt-2">{{ auth()->user()->posts()->sum('views') }}</div>
        </div>
    </div>

    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-black">My posts</h1>
            <a href="{{ route('dashboard.posts.create') }}" class="bg-slate-900 text-white px-4 py-2 rounded">New post</a>
        </div>

        <div class="space-y-3">
            @forelse(auth()->user()->posts()->latest()->get() as $post)
                <div class="border rounded p-4 flex items-center justify-between">
                    <div>
                        <div class="font-bold">{{ $post->title }}</div>
                        <div class="text-sm text-slate-500">{{ $post->status }} · {{ $post->published_at?->toFormattedDateString() ?? 'Not published yet' }}</div>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('dashboard.posts.edit', $post) }}" class="text-blue-700">Edit</a>
                    </div>
                </div>
            @empty
                <p class="text-slate-500">No posts yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
