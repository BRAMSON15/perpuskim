<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fakultas extends Model
{
    protected $table = 'fakultas';

    protected $fillable = [
        'nama_fakultas',
        'kode_fakultas',
        'deskripsi',
        'kepala_fakultas',
        'kontak',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all program studi under this faculty
     */
    public function programStudi(): HasMany
    {
        return $this->hasMany(ProgramStudi::class, 'fakultas_id');
    }

    /**
     * Get active program studi
     */
    public function activeProgramStudi(): HasMany
    {
        return $this->programStudi()->where('is_active', true);
    }

    /**
     * Scope: Get active faculties only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Count active program studi under this faculty
     */
    public function countActiveProgramStudi(): int
    {
        return $this->activeProgramStudi()->count();
    }

    /**
     * Get all program studi count
     */
    public function countAllProgramStudi(): int
    {
        return $this->programStudi()->count();
    }
}
