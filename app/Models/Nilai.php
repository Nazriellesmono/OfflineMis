<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'matkul',
        'nilai',
        'keterangan',
    ];

    /**
     * Relasi ke tabel users (setiap nilai milik satu user/mahasiswa)
     */
public function user()
{
    return $this->belongsTo(User::class);
}

public function frs()
{
    return $this->belongsTo(Frs::class, 'matkul', 'matkul');
}

}
