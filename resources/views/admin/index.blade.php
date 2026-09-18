@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <div class="text-sm text-slate-500">Users</div>
            <div class="text-3xl font-black mt-2">{{ $stats['users'] ?? 0 }}</div>
        </div>
        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <div class="text-sm text-slate-500">Posts</div>
            <div class="text-3xl font-black mt-2">{{ $stats['posts'] ?? 0 }}</div>
        </div>
        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <div class="text-sm text-slate-500">Pending</div>
            <div class="text-3xl font-black mt-2">{{ $stats['pending'] ?? 0 }}</div>
        </div>
        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <div class="text-sm text-slate-500">Views</div>
            <div class="text-3xl font-black mt-2">{{ $stats['views'] ?? 0 }}</div>
        </div>
    </div>

    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <h2 class="text-2xl font-bold mb-4">Recent moderation</h2>
        <div class="text-slate-600">Use the admin posts and categories sections to review submissions and publish content.</div>
    </div>
</div>
@endsection
