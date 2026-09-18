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

        $fields = $request->only([
            'site_name',
            'site_description',
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ]);

        foreach ($fields as $key => $value) {
            if ($value !== null && $value !== '') {
                Setting::setValue($key, $value);
            }
        }

        return back()->with('status', 'Settings saved.');
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
