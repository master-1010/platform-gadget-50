<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::query()->pluck('value', 'key')->all();

        return view('admin.settings', compact('settings'));
    }

    public function smtp()
    {
        $settings = Setting::query()->pluck('value', 'key')->all();

        return view('admin.settings-smtp', compact('settings'));
    }

    public function store(Request $request)
    {
        $this->authorize('viewAny', \App\Models\User::class);

        $validated = $request->validate([
            'site_name' => ['nullable', 'string', 'max:120'],
            'site_description' => ['nullable', 'string', 'max:1000'],
            'mail_mailer' => ['nullable', 'string', 'in:log,smtp,sendmail,array'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'integer', 'between:1,65535'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:1000'],
            'mail_encryption' => ['nullable', 'string', 'in:tls,ssl,null'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
            'mail_from_name' => ['nullable', 'string', 'max:120'],
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'mail_password' && ($value === null || $value === '')) {
                continue;
            }

            if ($value !== null) {
                Setting::setValue($key, $value);
            }
        }

        return back()->with('status', 'Settings saved securely.');
    }

    public function testEmail(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        try {
            Mail::raw('This is a test email from Public News.', function ($message) use ($request) {
                $message->to($request->input('email'))->subject('SMTP test');
            });

            return back()->with('status', 'Test email sent successfully.');
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['smtp' => 'Test email could not be sent. Check SMTP configuration.']);
        }
    }
}
