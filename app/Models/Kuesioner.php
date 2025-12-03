<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    use HasFactory;

    // Pastikan nama tabelnya benar (biasanya lowercase jamak atau singular tergantung database kamu)
    protected $table = 'kuesioner'; 

    // Kita gunakan $fillable agar aman dan sesuai dengan Controller
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5',
        'saran'
    ];

    // Relasi: Kuesioner ini diisi oleh Mahasiswa (User)
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // Relasi: Kuesioner ini menilai Dosen (User)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}