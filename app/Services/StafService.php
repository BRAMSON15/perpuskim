<?php

namespace App\Services;

use App\Models\Staf;
use Illuminate\Support\Facades\Hash;

class StafService
{
    /**
     * Create a new staf
     * 
     * @param array $data
     * @param string $role
     * @return Staf
     * @throws \Exception
     */
    public function createStaf(array $data, string $role = 'staf'): Staf
    {
        // Validate data
        if (empty($data['nama']) || empty($data['username']) || empty($data['password'])) {
            throw new \Exception('Nama, username, dan password wajib diisi.');
        }

        // Check if username already exists
        if ($this->usernameExists($data['username'])) {
            throw new \Exception('Username sudah digunakan.');
        }

        // Validate role
        $validRoles = ['admin', 'staf'];
        if (!in_array($role, $validRoles)) {
            throw new \Exception("Role '{$role}' tidak valid.");
        }

        \DB::beginTransaction();

        try {
            $staf = Staf::create([
                'nama' => $data['nama'],
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'role' => $role,
            ]);

            \DB::commit();

            return $staf;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update staf information
     * 
     * @param int $id
     * @param array $data
     * @return Staf
     * @throws \Exception
     */
    public function updateStaf(int $id, array $data): Staf
    {
        $staf = Staf::findOrFail($id);

        // Validate username uniqueness (except for current staf)
        if (isset($data['username']) && $data['username'] !== $staf->username) {
            if ($this->usernameExists($data['username'])) {
                throw new \Exception('Username sudah digunakan.');
            }
        }

        \DB::beginTransaction();

        try {
            $updateData = [];

            // Update basic fields
            if (isset($data['nama'])) {
                $updateData['nama'] = $data['nama'];
            }

            if (isset($data['username'])) {
                $updateData['username'] = $data['username'];
            }

            // Update password only if provided and not empty
            if (isset($data['password']) && !empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            // Update role if provided
            if (isset($data['role'])) {
                $validRoles = ['admin', 'staf'];
                if (!in_array($data['role'], $validRoles)) {
                    throw new \Exception("Role '{$data['role']}' tidak valid.");
                }
                $updateData['role'] = $data['role'];
            }

            $staf->update($updateData);

            \DB::commit();

            return $staf;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete staf
     * 
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteStaf(int $id): bool
    {
        $staf = Staf::findOrFail($id);

        // Prevent deletion of the only admin (optional security)
        if ($staf->role === 'admin' && $this->getAdminCount() <= 1) {
            throw new \Exception('Tidak dapat menghapus admin terakhir dalam sistem.');
        }

        return $staf->delete();
    }

    /**
     * Get all staf with specific role
     * 
     * @param string|null $role
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStaf(?string $role = null)
    {
        $query = Staf::latest();

        if ($role) {
            $query->where('role', $role);
        }

        return $query->get();
    }

    /**
     * Get staf by username
     * 
     * @param string $username
     * @return Staf|null
     */
    public function getByUsername(string $username): ?Staf
    {
        return Staf::where('username', $username)->first();
    }

    /**
     * Check if username already exists
     * 
     * @param string $username
     * @return bool
     */
    public function usernameExists(string $username): bool
    {
        return Staf::where('username', $username)->exists();
    }

    /**
     * Change password for staf
     * 
     * @param int $id
     * @param string $newPassword
     * @return bool
     */
    public function changePassword(int $id, string $newPassword): bool
    {
        $staf = Staf::findOrFail($id);
        return $staf->update([
            'password' => Hash::make($newPassword)
        ]);
    }

    /**
     * Verify password for staf
     * 
     * @param Staf $staf
     * @param string $password
     * @return bool
     */
    public function verifyPassword(Staf $staf, string $password): bool
    {
        return Hash::check($password, $staf->password);
    }

    /**
     * Get total count of staf
     * 
     * @return int
     */
    public function getTotalCount(): int
    {
        return Staf::count();
    }

    /**
     * Get total count of admin
     * 
     * @return int
     */
    public function getAdminCount(): int
    {
        return Staf::where('role', 'admin')->count();
    }

    /**
     * Get total count of regular staf
     * 
     * @return int
     */
    public function getRegularStafCount(): int
    {
        return Staf::where('role', 'staf')->count();
    }

    /**
     * Get all admins
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAdmins()
    {
        return Staf::where('role', 'admin')->get();
    }

    /**
     * Get all regular staf
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRegularStaf()
    {
        return Staf::where('role', 'staf')->get();
    }

    /**
     * Get staf statistics
     * 
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->getTotalCount(),
            'admin' => $this->getAdminCount(),
            'staf' => $this->getRegularStafCount(),
        ];
    }
}
