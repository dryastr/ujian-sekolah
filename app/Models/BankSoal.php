<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guru_id',
        'mata_pelajaran_id',
        'tahun_ajaran_id',
        'total_soal',
        'total_poin',
        'ujian_id',
        'is_archived',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}
