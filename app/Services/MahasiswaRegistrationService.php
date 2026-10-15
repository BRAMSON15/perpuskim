<?php

namespace App\Services;

use App\Models\Mahasiswa;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaRegistrationService
{
    private const STORAGE_DISK = 'public';
    private const CARD_IMAGE_PATH = 'kartu_mahasiswa';
    private const DEFAULT_STATUS = 'pending';

    /**
     * Register a new mahasiswa
     * 
     * @param array $data
     * @return Mahasiswa
     * @throws \Exception
     */
    public function register(array $data): Mahasiswa
    {
        \DB::beginTransaction();

        try {
            // Handle file upload if exists
            $fotoKartuPath = null;
            if (isset($data['foto_kartu']) && $data['foto_kartu'] instanceof UploadedFile) {
                $fotoKartuPath = $this->storeCardImage($data['foto_kartu']);
            }

            // Create mahasiswa record
            $mahasiswa = Mahasiswa::create([
                'npm' => $data['npm'],
                'nama' => $data['nama'],
                'fakultas' => $data['fakultas'],
                'email' => $data['email'],
                'alamat' => $data['alamat'],
                'no_telp' => $data['no_telp'],
                'password' => Hash::make($data['password']),
                'foto_kartu' => $fotoKartuPath,
                'status' => self::DEFAULT_STATUS,
            ]);

            \DB::commit();

            return $mahasiswa;
        } catch (\Exception $e) {
            \DB::rollBack();
            
            // Clean up uploaded file if transaction failed
            if (isset($fotoKartuPath)) {
                Storage::disk(self::STORAGE_DISK)->delete($fotoKartuPath);
            }

            throw $e;
        }
    }

    /**
     * Store card/ID image to storage
     * 
     * @param UploadedFile $file
     * @return string
     * @throws \Exception
     */
    public function storeCardImage(UploadedFile $file): string
    {
        try {
            // Validate file
            if (!$file->isValid()) {
                throw new \Exception('File upload tidak valid.');
            }

            // Generate unique filename with original extension
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store file
            $path = $file->storeAs(self::CARD_IMAGE_PATH, $filename, self::STORAGE_DISK);

            if (!$path) {
                throw new \Exception('Gagal menyimpan file kartu mahasiswa.');
            }

            return $path;
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengunggah file: ' . $e->getMessage());
        }
    }

    /**
     * Delete card image from storage
     * 
     * @param string $path
     * @return bool
     */
    public function deleteCardImage(string $path): bool
    {
        try {
            return Storage::disk(self::STORAGE_DISK)->delete($path);
        } catch (\Exception $e) {
            \Log::warning('Gagal menghapus foto kartu: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if NPM already registered
     * 
     * @param string $npm
     * @return bool
     */
    public function npmExists(string $npm): bool
    {
        return Mahasiswa::where('npm', $npm)->exists();
    }

    /**
     * Check if email already registered
     * 
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        return Mahasiswa::where('email', $email)->exists();
    }

    /**
     * Validate NPM format (14 digits)
     * 
     * @param string $npm
     * @return bool
     */
    public function isValidNpmFormat(string $npm): bool
    {
        return (bool) preg_match('/^\d{14}$/', $npm);
    }

    /**
     * Get mahasiswa by npm
     * 
     * @param string $npm
     * @return Mahasiswa|null
     */
    public function getMahasiswaByNpm(string $npm): ?Mahasiswa
    {
        return Mahasiswa::where('npm', $npm)->first();
    }

    /**
     * Get mahasiswa by email
     * 
     * @param string $email
     * @return Mahasiswa|null
     */
    public function getMahasiswaByEmail(string $email): ?Mahasiswa
    {
        return Mahasiswa::where('email', $email)->first();
    }

    /**
     * Update mahasiswa profile
     * 
     * @param Mahasiswa $mahasiswa
     * @param array $data
     * @return Mahasiswa
     */
    public function updateProfile(Mahasiswa $mahasiswa, array $data): Mahasiswa
    {
        $updateData = [];

        // Update basic fields
        foreach (['nama', 'email', 'alamat', 'no_telp', 'fakultas'] as $field) {
            if (isset($data[$field])) {
                $updateData[$field] = $data[$field];
            }
        }

        // Handle password update if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        // Handle new card image upload
        if (isset($data['foto_kartu']) && $data['foto_kartu'] instanceof UploadedFile) {
            // Delete old image
            if ($mahasiswa->foto_kartu) {
                $this->deleteCardImage($mahasiswa->foto_kartu);
            }
            // Store new image
            $updateData['foto_kartu'] = $this->storeCardImage($data['foto_kartu']);
        }

        $mahasiswa->update($updateData);
        return $mahasiswa;
    }

    /**
     * Get total pending registrations
     * 
     * @return int
     */
    public function getPendingCount(): int
    {
        return Mahasiswa::where('status', 'pending')->count();
    }

    /**
     * Get all pending registrations
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingRegistrations()
    {
        return Mahasiswa::where('status', 'pending')
            ->latest('created_at')
            ->get();
    }
}
