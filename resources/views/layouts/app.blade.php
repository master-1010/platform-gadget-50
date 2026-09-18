<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? config('app.name', 'Public News') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <header class="bg-slate-950 text-white">
        <div class="max-w-6xl mx-auto p-4 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('home') }}" class="font-bold text-xl">{{ config('app.name', 'Public News') }}</a>
            <nav class="flex flex-wrap items-center gap-4 text-sm">
                <a href="{{ route('home') }}">Home</a>
                @auth
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                    <a href="{{ route('profile.show') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button type="submit">Logout</button></form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-4">
        @if(session('status'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
