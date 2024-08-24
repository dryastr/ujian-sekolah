<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaKelas extends Model
{
    use HasFactory;

    protected $fillable = ['siswa_id', 'kelas_id', 'tahun_ajaran_id'];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
