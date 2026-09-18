@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-black mb-2">Install Public News</h1>
    <p class="text-slate-600 mb-6">Set up the application, create the first admin account, and complete the installation securely.</p>

    <div class="mb-6 rounded border border-slate-200 bg-slate-50 p-4">
        <p class="font-semibold">Database status</p>
        <p class="text-sm {{ $dbAvailable ? 'text-green-600' : 'text-red-600' }}">
            {{ $dbAvailable ? 'Database connection available' : 'Database connection unavailable' }}
        </p>
    </div>

    <form method="POST" class="space-y-4" action="{{ route('install.store') }}">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Website name</label>
            <input name="website_name" value="{{ old('website_name') }}" required class="w-full border rounded px-3 py-2" placeholder="Public News" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Admin name</label>
            <input name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Admin username</label>
            <input name="username" value="{{ old('username') }}" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Admin email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Admin password</label>
            <input type="password" name="password" required minlength="12" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Confirm password</label>
            <input type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2" />
        </div>

        <button type="submit" class="w-full bg-slate-900 text-white rounded px-4 py-2 font-semibold">
            Install application
        </button>
    </form>
</div>
@endsection
