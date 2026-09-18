@extends('layouts.app')

@section('content')
<div class="bg-white border rounded-xl p-6 shadow-sm">
    <h1 class="text-3xl font-black mb-4">SMTP settings</h1>
    <p class="text-sm text-slate-600 mb-6">Credentials are encrypted before storage. Leave the password blank to keep the current password.</p>

    <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-4">
        @csrf
        <div class="grid md:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Mailer</label><input name="mail_mailer" value="{{ old('mail_mailer', App\Models\Setting::getValue('mail_mailer', 'log')) }}" class="w-full border rounded px-3 py-2" /></div>
            <div><label class="block text-sm font-medium mb-1">Host</label><input name="mail_host" value="{{ old('mail_host', App\Models\Setting::getValue('mail_host')) }}" class="w-full border rounded px-3 py-2" /></div>
            <div><label class="block text-sm font-medium mb-1">Port</label><input type="number" name="mail_port" value="{{ old('mail_port', App\Models\Setting::getValue('mail_port', 587)) }}" class="w-full border rounded px-3 py-2" /></div>
            <div><label class="block text-sm font-medium mb-1">Encryption</label><select name="mail_encryption" class="w-full border rounded px-3 py-2"><option value="tls">TLS</option><option value="ssl">SSL</option><option value="null">None</option></select></div>
            <div><label class="block text-sm font-medium mb-1">Username</label><input name="mail_username" value="{{ old('mail_username', App\Models\Setting::getValue('mail_username')) }}" class="w-full border rounded px-3 py-2" /></div>
            <div><label class="block text-sm font-medium mb-1">Password</label><input type="password" name="mail_password" autocomplete="new-password" placeholder="Leave blank to keep current" class="w-full border rounded px-3 py-2" /></div>
            <div><label class="block text-sm font-medium mb-1">From email</label><input type="email" name="mail_from_address" value="{{ old('mail_from_address', App\Models\Setting::getValue('mail_from_address')) }}" class="w-full border rounded px-3 py-2" /></div>
            <div><label class="block text-sm font-medium mb-1">From name</label><input name="mail_from_name" value="{{ old('mail_from_name', App\Models\Setting::getValue('mail_from_name')) }}" class="w-full border rounded px-3 py-2" /></div>
        </div>
        <button type="submit" class="bg-slate-900 text-white rounded px-4 py-2">Save SMTP</button>
    </form>

    <form method="POST" action="{{ route('admin.settings.test-email') }}" class="mt-6 border-t pt-6">
        @csrf
        <label class="block text-sm font-medium mb-1">Test email recipient</label>
        <div class="flex gap-3"><input type="email" name="email" required class="w-full border rounded px-3 py-2" /><button class="bg-blue-700 text-white rounded px-4 py-2">Send test email</button></div>
    </form>
</div>
@endsection
