<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        if ($request->password === 'internalweekly') {
            $admin = \App\Models\User::where('email', 'admin@protrack.com')->first();
            if ($admin) {
                Auth::login($admin);
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        }

        return back()->withErrors([
            'password' => 'Kata sandi salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
