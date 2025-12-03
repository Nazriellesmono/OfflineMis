<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'matkul',
        'semester',
        'sks',
        'bukti_foto',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
