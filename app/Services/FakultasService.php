<?php

namespace App\Services;

use App\Models\Fakultas;

class FakultasService
{
    /**
     * Get all fakultas
     */
    public function getAll()
    {
        return Fakultas::latest()->get();
    }

    /**
     * Get all active fakultas
     */
    public function getActive()
    {
        return Fakultas::active()->latest()->get();
    }

    /**
     * Get fakultas with pagination
     */
    public function paginate($perPage = 10)
    {
        return Fakultas::paginate($perPage);
    }

    /**
     * Get fakultas by ID
     */
    public function getById($id)
    {
        return Fakultas::findOrFail($id);
    }

    /**
     * Create new fakultas
     */
    public function create(array $data): Fakultas
    {
        \DB::beginTransaction();

        try {
            // Check if kode_fakultas already exists
            if ($this->kodeFakultasExists($data['kode_fakultas'])) {
                throw new \Exception('Kode Fakultas sudah digunakan.');
            }

            $fakultas = Fakultas::create($data);

            \DB::commit();

            return $fakultas;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update fakultas
     */
    public function update($id, array $data): Fakultas
    {
        $fakultas = Fakultas::findOrFail($id);

        \DB::beginTransaction();

        try {
            // Check if kode_fakultas is unique (except for current record)
            if (isset($data['kode_fakultas']) && $data['kode_fakultas'] !== $fakultas->kode_fakultas) {
                if ($this->kodeFakultasExists($data['kode_fakultas'])) {
                    throw new \Exception('Kode Fakultas sudah digunakan.');
                }
            }

            $fakultas->update($data);

            \DB::commit();

            return $fakultas;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete fakultas
     */
    public function delete($id): bool
    {
        $fakultas = Fakultas::findOrFail($id);

        \DB::beginTransaction();

        try {
            // Check if fakultas has active program studi
            if ($fakultas->countActiveProgramStudi() > 0) {
                throw new \Exception('Tidak dapat menghapus Fakultas yang masih memiliki Program Studi aktif.');
            }

            $fakultas->delete();

            \DB::commit();

            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Toggle status
     */
    public function toggleStatus($id): Fakultas
    {
        $fakultas = Fakultas::findOrFail($id);

        $fakultas->update([
            'is_active' => !$fakultas->is_active
        ]);

        return $fakultas;
    }

    /**
     * Search fakultas
     */
    public function search($query)
    {
        return Fakultas::where('nama_fakultas', 'like', "%{$query}%")
            ->orWhere('kode_fakultas', 'like', "%{$query}%")
            ->orWhere('kepala_fakultas', 'like', "%{$query}%")
            ->latest()
            ->get();
    }

    /**
     * Check if kode_fakultas exists
     */
    private function kodeFakultasExists($kodeFakultas): bool
    {
        return Fakultas::where('kode_fakultas', $kodeFakultas)->exists();
    }

    /**
     * Get statistics
     */
    public function getStatistics(): array
    {
        return [
            'total' => Fakultas::count(),
            'active' => Fakultas::where('is_active', true)->count(),
            'inactive' => Fakultas::where('is_active', false)->count(),
        ];
    }
}
