@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white border rounded-xl p-6 shadow-sm">
    <h1 class="text-3xl font-black mb-4">Edit profile</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Full name</label>
            <input name="name" value="{{ old('name', $user->name) }}" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Address</label>
            <textarea name="address" rows="3" class="w-full border rounded px-3 py-2">{{ old('address', $user->address) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Bio</label>
            <textarea name="bio" rows="5" class="w-full border rounded px-3 py-2">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Profile photo</label>
            <input type="file" name="avatar" accept="image/*" class="w-full border rounded px-3 py-2" />
        </div>

        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Save profile</button>
    </form>
</div>
@endsection
