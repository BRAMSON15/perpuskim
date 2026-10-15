<?php

namespace App\Services;

use App\Models\ProgramStudi;
use App\Models\Fakultas;

class ProgramStudiService
{
    /**
     * Get all program studi
     */
    public function getAll()
    {
        return ProgramStudi::with('fakultas')->latest()->get();
    }

    /**
     * Get all active program studi
     */
    public function getActive()
    {
        return ProgramStudi::active()->with('fakultas')->latest()->get();
    }

    /**
     * Get program studi by fakultas
     */
    public function getByFakultas($fakultasId)
    {
        return ProgramStudi::where('fakultas_id', $fakultasId)
            ->with('fakultas')
            ->latest()
            ->get();
    }

    /**
     * Get program studi with pagination
     */
    public function paginate($perPage = 10)
    {
        return ProgramStudi::with('fakultas')->paginate($perPage);
    }

    /**
     * Get program studi by ID
     */
    public function getById($id)
    {
        return ProgramStudi::with('fakultas')->findOrFail($id);
    }

    /**
     * Create new program studi
     */
    public function create(array $data): ProgramStudi
    {
        \DB::beginTransaction();

        try {
            // Verify fakultas exists
            Fakultas::findOrFail($data['fakultas_id']);

            // Check if kode_program_studi already exists
            if ($this->kodeProgramStudiExists($data['kode_program_studi'])) {
                throw new \Exception('Kode Program Studi sudah digunakan.');
            }

            $programStudi = ProgramStudi::create($data);

            \DB::commit();

            return $programStudi;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update program studi
     */
    public function update($id, array $data): ProgramStudi
    {
        $programStudi = ProgramStudi::findOrFail($id);

        \DB::beginTransaction();

        try {
            // If changing fakultas, verify new fakultas exists
            if (isset($data['fakultas_id']) && $data['fakultas_id'] !== $programStudi->fakultas_id) {
                Fakultas::findOrFail($data['fakultas_id']);
            }

            // Check if kode_program_studi is unique (except for current record)
            if (isset($data['kode_program_studi']) && $data['kode_program_studi'] !== $programStudi->kode_program_studi) {
                if ($this->kodeProgramStudiExists($data['kode_program_studi'])) {
                    throw new \Exception('Kode Program Studi sudah digunakan.');
                }
            }

            $programStudi->update($data);

            \DB::commit();

            return $programStudi;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete program studi
     */
    public function delete($id): bool
    {
        $programStudi = ProgramStudi::findOrFail($id);

        \DB::beginTransaction();

        try {
            $programStudi->delete();

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
    public function toggleStatus($id): ProgramStudi
    {
        $programStudi = ProgramStudi::findOrFail($id);

        $programStudi->update([
            'is_active' => !$programStudi->is_active
        ]);

        return $programStudi;
    }

    /**
     * Search program studi
     */
    public function search($query)
    {
        return ProgramStudi::where('nama_program_studi', 'like', "%{$query}%")
            ->orWhere('kode_program_studi', 'like', "%{$query}%")
            ->orWhere('jenjang', 'like', "%{$query}%")
            ->with('fakultas')
            ->latest()
            ->get();
    }

    /**
     * Check if kode_program_studi exists
     */
    private function kodeProgramStudiExists($kodeProgramStudi): bool
    {
        return ProgramStudi::where('kode_program_studi', $kodeProgramStudi)->exists();
    }

    /**
     * Get statistics
     */
    public function getStatistics(): array
    {
        return [
            'total' => ProgramStudi::count(),
            'active' => ProgramStudi::where('is_active', true)->count(),
            'inactive' => ProgramStudi::where('is_active', false)->count(),
            'by_jenjang' => $this->getByJenjang(),
        ];
    }

    /**
     * Get program studi grouped by jenjang
     */
    public function getByJenjang(): array
    {
        $result = [];
        $data = ProgramStudi::select('jenjang')
            ->distinct()
            ->where('jenjang', '!=', null)
            ->get();

        foreach ($data as $item) {
            $result[$item->jenjang] = ProgramStudi::where('jenjang', $item->jenjang)->count();
        }

        return $result;
    }

    /**
     * Get all distinct jenjang
     */
    public function getDistinctJenjang(): array
    {
        return ProgramStudi::distinct()
            ->where('jenjang', '!=', null)
            ->pluck('jenjang')
            ->toArray();
    }
}
