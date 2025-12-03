<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // pastikan kolom 'role' ada di database
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi: satu user (mahasiswa) punya banyak FRS
     */
    public function frs()
    {
        return $this->hasMany(Frs::class, 'user_id');
    }

    /**
     * Relasi: satu user (mahasiswa) punya banyak nilai
     */
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'user_id');
    }
}
