<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staf extends Authenticatable
{
    use Notifiable;

    protected $table = 'staf';

    protected $fillable = [
        'nama',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
