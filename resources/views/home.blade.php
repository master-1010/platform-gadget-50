@extends('layouts.app')

@section('content')
<section class="py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-4xl font-black">Latest News</h1>
        <form method="GET" action="{{ route('search') }}" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search news" class="border rounded px-3 py-2 w-64" />
            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Search</button>
        </form>
    </div>

    <div class="grid md:grid-cols-3 gap-5">
        @forelse($posts as $post)
            <article class="bg-white rounded-xl shadow-sm border p-5">
                <p class="text-sm text-blue-700 font-semibold">{{ $post->category?->name ?? 'General' }}</p>
                <h2 class="text-xl font-bold mt-2">
                    <a href="{{ route('news.show', $post) }}" class="hover:text-blue-700">{{ $post->title }}</a>
                </h2>
                <p class="text-slate-600 mt-3">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 140) }}</p>
                <div class="mt-4 text-xs text-slate-500">
                    {{ $post->published_at?->toFormattedDateString() ?? 'Recently' }} · {{ $post->views }} views
                </div>
            </article>
        @empty
            <p class="text-slate-600">No published news yet.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</section>
@endsection
