<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaAuthController extends Controller
{
    public function showRegister()
    {
        return view('mahasiswa.register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'npm' => 'required|string|regex:/^\d{14}$/|unique:mahasiswa,npm',
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mahasiswa,email',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'foto_kartu' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'npm.unique' => 'NPM ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'foto_kartu.required' => 'Foto/Scan Kartu wajib diunggah.',
            'foto_kartu.image' => 'File harus berupa gambar.',
            'foto_kartu.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $request->file('foto_kartu')->store('kartu_mahasiswa', 'public');

        Mahasiswa::create([
            'npm' => $request->npm,
            'nama' => $request->nama,
            'fakultas' => $request->fakultas,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'foto_kartu' => $path,
            'status' => 'pending', // Menunggu verifikasi admin
        ]);

        return redirect('/')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu verifikasi oleh Admin.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'npm' => ['required', 'string', 'regex:/^\d{14}$/'],
            'password' => ['required', 'string'],
        ], [
            'npm.required' => 'NPM harus diisi',
            'npm.regex' => 'NPM harus terdiri dari 14 digit angka',
            'password.required' => 'Password harus diisi',
        ]);

        $mahasiswa = Mahasiswa::where('npm', $credentials['npm'])->first();

        if (!$mahasiswa || !Hash::check($credentials['password'], $mahasiswa->password)) {
            return back()->withErrors([
                'npm' => 'NPM atau password salah',
            ])->onlyInput('npm');
        }

        if ($mahasiswa->status === 'pending') {
            return back()->withErrors(['npm' => 'Akun Anda sedang menunggu verifikasi oleh Admin.'])->onlyInput('npm');
        } elseif ($mahasiswa->status === 'rejected') {
            return back()->withErrors(['npm' => 'Pendaftaran akun Anda ditolak. Silakan hubungi Admin.'])->onlyInput('npm');
        }

        Auth::guard('mahasiswa')->login($mahasiswa);

        return redirect()->route('mahasiswa.home')->with('success', 'Login berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }

    public function home()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.home', compact('mahasiswa'));
    }
}
