@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl border p-6">
    <h1 class="text-3xl font-black mb-4">Search results</h1>

    @if($query)
        <p class="text-slate-600 mb-4">Showing results for: <strong>{{ $query }}</strong></p>
    @endif

    @forelse($posts as $post)
        <article class="border-b py-4">
            <a href="{{ route('news.show', $post) }}" class="text-xl font-bold hover:text-blue-700">{{ $post->title }}</a>
            <p class="text-slate-600 mt-2">{{ Str::limit(strip_tags($post->content), 180) }}</p>
        </article>
    @empty
        <p class="text-slate-600">No search results found.</p>
    @endforelse

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
