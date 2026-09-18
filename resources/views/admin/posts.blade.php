@extends('layouts.app')

@section('content')
<div class="bg-white border rounded-xl p-6 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-black">Posts</h1>
        <a href="{{ route('admin.categories.index') }}" class="bg-slate-900 text-white px-4 py-2 rounded">Categories</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-3 pr-4">Title</th>
                    <th class="py-3 pr-4">Author</th>
                    <th class="py-3 pr-4">Status</th>
                    <th class="py-3 pr-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr class="border-b">
                        <td class="py-3 pr-4">{{ $post->title }}</td>
                        <td class="py-3 pr-4">{{ $post->user?->name ?? 'Unknown' }}</td>
                        <td class="py-3 pr-4">{{ $post->status }}</td>
                        <td class="py-3 pr-4 space-x-2">
                            <form method="POST" action="{{ route('admin.posts.approve', $post) }}" class="inline">@csrf<button class="bg-green-600 text-white px-3 py-1 rounded">Approve</button></form>
                            <form method="POST" action="{{ route('admin.posts.reject', $post) }}" class="inline">@csrf<input type="text" name="reason" placeholder="Reason" class="border rounded px-2 py-1 mr-2" /><button class="bg-red-600 text-white px-3 py-1 rounded">Reject</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-4 text-slate-500">No posts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $posts->links() }}</div>
</div>
@endsection
