<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::query()->where($field, $credentials['login'])->first();

        if ($user && $user->isLockedOut()) {
            return back()->withErrors(['login' => 'This account is temporarily locked due to repeated failed attempts.'])->withInput();
        }

        if (! $user || ! Auth::attempt([
            $field => $credentials['login'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            if ($user) {
                $user->recordFailedLogin($request->ip(), $request->userAgent());
            }

            return back()->withErrors(['login' => 'Invalid credentials.'])->withInput();
        }

        $user->loginAttempts()->delete();
        $user->securityLockouts()->delete();

        $request->session()->regenerate();

        return redirect()->intended($user->isAdmin() ? route('admin.index') : route('dashboard.index'));
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:40', 'alpha_dash', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:12'],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'citizen',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
