<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InstallController extends Controller
{
    public function index()
    {
        if (file_exists(storage_path('app/installed.lock'))) {
            return redirect()->route('login');
        }

        $dbAvailable = false;

        try {
            DB::connection()->getPdo();
            $dbAvailable = true;
        } catch (\Throwable) {
            $dbAvailable = false;
        }

        return view('install', compact('dbAvailable'));
    }

    public function store(Request $request)
    {
        abort_if(file_exists(storage_path('app/installed.lock')), 404);

        $validated = $request->validate([
            'website_name' => ['required', 'string', 'max:120'],
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'alpha_dash', 'max:40', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        try {
            DB::connection()->getPdo();

            Artisan::call('migrate', ['--force' => true]);

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'admin',
            ]);

            $user->email_verified_at = now();
            $user->save();

            $this->writeInstallLock();

            return redirect()->route('login')->with('status', 'Installation complete.');
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors([
                'install' => 'Installation failed. Please validate your database settings and file permissions.',
            ]);
        }
    }

    protected function writeInstallLock(): void
    {
        $path = storage_path('app/installed.lock');
        $dir = dirname($path);

        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents($path, now()->toDateTimeString() . PHP_EOL);
    }
}
