<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'ujian_id',
        'guru_id',
        'bank_soal_id',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
        'point',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class);
    }

    public function bankSoal()
    {
        return $this->belongsTo(BankSoal::class);
    }
}
