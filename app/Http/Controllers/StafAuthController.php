<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StafAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('stafperpus.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('staf')->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::guard('staf')->user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/stafperpus/home');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('staf')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/stafperpus/login');
    }
}
