<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MahasiswaRegistrationService;
use App\Services\MahasiswaAuthenticationService;

class MahasiswaAuthController extends Controller
{
    private $registrationService;
    private $authService;

    public function __construct(
        MahasiswaRegistrationService $registrationService,
        MahasiswaAuthenticationService $authService
    ) {
        $this->registrationService = $registrationService;
        $this->authService = $authService;
    }

    public function showRegister()
    {
        return view('mahasiswa.register');
    }

    public function processRegister(Request $request)
    {
        $validated = $request->validate([
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

        try {
            $mahasiswa = $this->registrationService->register($validated);
            
            return redirect('/')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu verifikasi oleh Admin.');
        } catch (\Exception $e) {
            return back()->withErrors(['foto_kartu' => $e->getMessage()]);
        }
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

        try {
            $mahasiswa = $this->authService->authenticate($credentials['npm'], $credentials['password']);
            $this->authService->login($mahasiswa);

            return redirect()->route('mahasiswa.home')->with('success', 'Login berhasil!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'npm' => $e->getMessage(),
            ])->onlyInput('npm');
        }
    }

    public function logout(Request $request)
    {
        $this->authService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }

    public function home()
    {
        $mahasiswa = $this->authService->getAuthenticatedUser();
        return view('mahasiswa.home', compact('mahasiswa'));
    }
}
