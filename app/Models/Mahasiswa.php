<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'npm';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'npm',
        'nama',
        'email',
        'password',
        'prodi',
        'no_telp',
        'fakultas',
        'alamat',
        'foto_kartu',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
