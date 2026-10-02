<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $d = $r->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($d, $r->boolean('remember'))) {
            $r->session()->regenerate();

            return redirect()->intended(
                auth()->user()->role === 'admin'
                    ? route('admin.dashboard')
                    : route('dashboard')
            );
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        $d = $r->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $u = User::create([
            'name' => $d['name'],
            'email' => $d['email'],
            'password' => $d['password'],
        ]);

        Auth::login($u);

        $r->session()->regenerate();

        return redirect('/dashboard');
    }

    public function logout(Request $r)
    {
        Auth::logout();

        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect('/');
    }
}
