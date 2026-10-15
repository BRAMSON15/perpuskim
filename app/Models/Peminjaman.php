<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'mahasiswa_npm',
        'buku_id',
        'tanggal_pinjam',
        'tenggat_waktu',
        'tanggal_kembali',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tenggat_waktu' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_npm', 'npm');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
