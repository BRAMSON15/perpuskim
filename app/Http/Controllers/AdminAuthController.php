<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('staf')->attempt($credentials)) {
            $user = Auth::guard('staf')->user();
            
            // Periksa apakah user memiliki role admin
            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            } else {
                // Jika bukan admin, logout dan beri pesan error
                Auth::guard('staf')->logout();
                return back()->with('error', 'Anda tidak memiliki akses sebagai Administrator.');
            }
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('staf')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
