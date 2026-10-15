<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'kategori',
        'fakultas',
        'deskripsi',
        'stok',
        'gambar',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
}
