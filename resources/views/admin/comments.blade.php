@extends('layouts.app')

@section('content')
<div class="bg-white border rounded-xl p-6 shadow-sm">
    <h1 class="text-3xl font-black mb-4">Comments</h1>

    <div class="space-y-3">
        @forelse($comments as $comment)
            <div class="border rounded p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold">{{ $comment->name }}</div>
                        <div class="text-sm text-slate-500">{{ $comment->post?->title ?? 'Post deleted' }}</div>
                    </div>
                    <span class="text-xs bg-slate-100 px-2 py-1 rounded">{{ $comment->status }}</span>
                </div>
                <div class="mt-3 text-slate-700">{{ $comment->body }}</div>
                <div class="mt-3 flex gap-2">
                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">@csrf<button class="bg-green-600 text-white px-3 py-1 rounded">Approve</button></form>
                    <form method="POST" action="{{ route('admin.comments.reject', $comment) }}">@csrf<button class="bg-red-600 text-white px-3 py-1 rounded">Reject</button></form>
                </div>
            </div>
        @empty
            <p class="text-slate-500">No comments yet.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $comments->links() }}</div>
</div>
@endsection
