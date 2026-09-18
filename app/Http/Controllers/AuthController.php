<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = filter_var($validated['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! Auth::attempt([
            $field => $validated['login'],
            'password' => $validated['password'],
        ], $request->boolean('remember'))) {
            return back()->withErrors(['login' => 'Invalid credentials.'])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.index'));
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:40', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:12'],
            'terms' => ['accepted'],
        ]);

        $user = new \App\Models\User();
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $user->role = 'citizen';
        $user->save();

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
