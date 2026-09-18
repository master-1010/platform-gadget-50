@extends('layouts.app')

@section('content')
<article class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border p-6">
    <div class="mb-4 text-sm text-blue-700 font-semibold">
        {{ $post->category?->name ?? 'General' }}
    </div>

    <h1 class="text-4xl font-black leading-tight">{{ $post->title }}</h1>

    <div class="mt-4 text-sm text-slate-500">
        {{ $post->anonymous ? 'Anonymous reporter' : $post->user?->name }} · {{ $post->published_at?->toFormattedDateString() ?? 'Recently' }}
    </div>

    @if($post->featured_image)
        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full mt-6 rounded-lg" />
    @elseif($post->external_image_url)
        <img src="{{ $post->external_image_url }}" alt="{{ $post->title }}" class="w-full mt-6 rounded-lg" />
    @endif

    <div class="prose max-w-none mt-8">
        {!! nl2br(e($post->content)) !!}
    </div>

    <div class="mt-8 flex items-center gap-3">
        <form method="POST" action="{{ route('news.like', $post) }}">
            @csrf
            <button type="submit" class="bg-slate-900 text-white rounded px-4 py-2">Like ({{ $post->likes_count }})</button>
        </form>
    </div>

    <section class="mt-12">
        <h2 class="text-2xl font-bold mb-4">Comments</h2>

        @forelse($post->comments()->where('status', 'approved')->latest()->get() as $comment)
            <div class="border-b py-3">
                <div class="font-semibold">{{ $comment->name }}</div>
                <div class="text-slate-700 mt-1">{{ $comment->body }}</div>
            </div>
        @empty
            <p class="text-slate-500">No comments yet.</p>
        @endforelse

        <form method="POST" action="{{ route('news.comments.store', $post) }}" class="mt-6 space-y-3">
            @csrf
            <input name="name" placeholder="Your name" required class="w-full border rounded px-3 py-2" />
            <input name="email" type="email" placeholder="Email (optional)" class="w-full border rounded px-3 py-2" />
            <textarea name="body" rows="5" required placeholder="Write your comment" class="w-full border rounded px-3 py-2"></textarea>
            <button type="submit" class="bg-blue-700 text-white rounded px-4 py-2">Submit comment</button>
        </form>
    </section>
</article>
@endsection
