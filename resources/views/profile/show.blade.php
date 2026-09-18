@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white border rounded-xl p-6 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-black">My profile</h1>
        <a href="{{ route('profile.edit') }}" class="bg-slate-900 text-white px-4 py-2 rounded">Edit profile</a>
    </div>

    <div class="flex items-center gap-6 mb-6">
        @if($user->avatar_path)
            <img src="{{ Storage::url($user->avatar_path) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border" />
        @else
            <div class="w-20 h-20 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xl">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif

        <div>
            <div class="text-2xl font-bold">{{ $user->name }}</div>
            <div class="text-slate-500">@ {{ $user->username }}</div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4 text-sm">
        <div class="border rounded p-3"><strong>Email:</strong> {{ $user->email }}</div>
        <div class="border rounded p-3"><strong>Phone:</strong> {{ $user->phone ?? 'Not set' }}</div>
        <div class="md:col-span-2 border rounded p-3"><strong>Address:</strong> {{ $user->address ?? 'Not set' }}</div>
        <div class="md:col-span-2 border rounded p-3"><strong>Bio:</strong> {{ $user->bio ?? 'No bio added yet.' }}</div>
    </div>
</div>
@endsection
