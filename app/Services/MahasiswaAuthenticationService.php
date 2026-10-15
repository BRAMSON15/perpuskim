<?php

namespace App\Services;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MahasiswaAuthenticationService
{
    /**
     * Authenticate mahasiswa with NPM and password
     * 
     * @param string $npm
     * @param string $password
     * @return Mahasiswa
     * @throws \Exception
     */
    public function authenticate(string $npm, string $password): Mahasiswa
    {
        $mahasiswa = Mahasiswa::where('npm', $npm)->first();

        if (!$mahasiswa) {
            throw new \Exception('NPM atau password salah');
        }

        if (!Hash::check($password, $mahasiswa->password)) {
            throw new \Exception('NPM atau password salah');
        }

        // Check account status
        if ($mahasiswa->status === 'pending') {
            throw new \Exception('Akun Anda sedang menunggu verifikasi oleh Admin.');
        }

        if ($mahasiswa->status === 'rejected') {
            throw new \Exception('Pendaftaran akun Anda ditolak. Silakan hubungi Admin.');
        }

        if ($mahasiswa->status === 'nonaktif') {
            throw new \Exception('Akun Anda tidak aktif. Silakan hubungi Admin.');
        }

        return $mahasiswa;
    }

    /**
     * Login mahasiswa using guard
     * 
     * @param Mahasiswa $mahasiswa
     * @param bool $remember
     * @return void
     */
    public function login(Mahasiswa $mahasiswa, bool $remember = false): void
    {
        Auth::guard('mahasiswa')->login($mahasiswa, $remember);
    }

    /**
     * Logout current mahasiswa
     * 
     * @return void
     */
    public function logout(): void
    {
        Auth::guard('mahasiswa')->logout();
    }

    /**
     * Get authenticated mahasiswa
     * 
     * @return Mahasiswa|null
     */
    public function getAuthenticatedUser(): ?Mahasiswa
    {
        return Auth::guard('mahasiswa')->user();
    }

    /**
     * Check if mahasiswa is authenticated
     * 
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return Auth::guard('mahasiswa')->check();
    }

    /**
     * Validate NPM format
     * 
     * @param string $npm
     * @return bool
     */
    public function isValidNpmFormat(string $npm): bool
    {
        return (bool) preg_match('/^\d{14}$/', $npm);
    }

    /**
     * Change password for mahasiswa
     * 
     * @param Mahasiswa $mahasiswa
     * @param string $newPassword
     * @return bool
     */
    public function changePassword(Mahasiswa $mahasiswa, string $newPassword): bool
    {
        return $mahasiswa->update([
            'password' => Hash::make($newPassword)
        ]);
    }

    /**
     * Verify current password
     * 
     * @param Mahasiswa $mahasiswa
     * @param string $password
     * @return bool
     */
    public function verifyPassword(Mahasiswa $mahasiswa, string $password): bool
    {
        return Hash::check($password, $mahasiswa->password);
    }

    /**
     * Check if password needs to be changed (optional - for security policies)
     * 
     * @param Mahasiswa $mahasiswa
     * @return bool
     */
    public function shouldChangePassword(Mahasiswa $mahasiswa): bool
    {
        // Implement your password change policy here
        // For example: if password was last changed more than 90 days ago
        return false;
    }
}
