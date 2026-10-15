<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';

    protected $fillable = [
        'fakultas_id',
        'nama_program_studi',
        'kode_program_studi',
        'deskripsi',
        'jenjang',
        'ketua_program',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the faculty this program study belongs to
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    /**
     * Scope: Get active program studi only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get by faculty
     */
    public function scopeByFakultas($query, $fakultasId)
    {
        return $query->where('fakultas_id', $fakultasId);
    }

    /**
     * Get faculty name
     */
    public function getFakultasNameAttribute(): string
    {
        return $this->fakultas?->nama_fakultas ?? '-';
    }
}
