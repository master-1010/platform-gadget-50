@extends('layouts.app')

@section('content')
<div class="bg-white border rounded-xl p-6 shadow-sm">
    <h1 class="text-3xl font-black mb-4">Site settings</h1>

    <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Website name</label>
            <input name="site_name" value="{{ old('site_name', App\Models\Setting::getValue('site_name', config('app.name'))) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Website description</label>
            <textarea name="site_description" rows="3" class="w-full border rounded px-3 py-2">{{ old('site_description', App\Models\Setting::getValue('site_description')) }}</textarea>
        </div>

        <button type="submit" class="bg-slate-900 text-white rounded px-4 py-2">Save settings</button>
    </form>
</div>
@endsection
