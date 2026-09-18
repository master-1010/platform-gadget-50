@extends('layouts.app')

@section('content')
<div class="bg-white border rounded-xl p-6 shadow-sm">
    <h1 class="text-3xl font-black mb-4">Categories</h1>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="mb-6 grid md:grid-cols-3 gap-3">
        @csrf
        <input name="name" required placeholder="Category name" class="border rounded px-3 py-2" />
        <input name="description" placeholder="Description" class="border rounded px-3 py-2" />
        <button type="submit" class="bg-slate-900 text-white rounded px-4 py-2">Create category</button>
    </form>

    <div class="space-y-3">
        @forelse($categories as $category)
            <div class="border rounded p-3 flex items-center justify-between">
                <div>
                    <div class="font-bold">{{ $category->name }}</div>
                    <div class="text-sm text-slate-500">{{ $category->description ?: 'No description' }}</div>
                </div>
                <span class="text-xs bg-slate-100 px-2 py-1 rounded">{{ $category->slug }}</span>
            </div>
        @empty
            <p class="text-slate-500">No categories yet.</p>
        @endforelse
    </div>
</div>
@endsection
