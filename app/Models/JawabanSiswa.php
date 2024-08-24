<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'hasil_ujian_id',
        'soal_id',
        'jawaban',
        'status_benar',
    ];

    public function hasilUjian()
    {
        return $this->belongsTo(HasilUjian::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
