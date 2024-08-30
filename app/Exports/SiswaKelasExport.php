<?php

namespace App\Exports;

use App\Models\SiswaKelas;
use App\Models\HasilUjian;
use App\Models\Kelas;
use App\Models\Ujian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaKelasExport implements FromCollection, WithHeadings
{
    protected $ujian_id;
    protected $kelas_id;
    protected $ujian;
    protected $kelas;

    public function __construct($ujian_id, $kelas_id)
    {
        $this->ujian_id = $ujian_id;
        $this->kelas_id = $kelas_id;
        $this->ujian = Ujian::find($ujian_id);
        $this->kelas = Kelas::find($kelas_id);
    }

    public function collection()
    {
        return SiswaKelas::with('siswa')
            ->where('kelas_id', $this->kelas_id)
            ->get()
            ->map(function ($siswaKelasItem) {
                $hasilUjian = HasilUjian::where('ujian_id', $this->ujian_id)
                    ->where('siswa_id', $siswaKelasItem->siswa_id)
                    ->first();

                return [
                    'NIS' => $siswaKelasItem->siswa->nis,
                    'Nama Siswa' => $siswaKelasItem->siswa->name,
                    'Email' => $siswaKelasItem->siswa->email,
                    'Kelas' => $this->kelas->name,
                    'Ujian' => $this->ujian->name,
                    'Sudah Mengerjakan' => $hasilUjian ? 'Ya' : 'Tidak',
                    'Nilai' => $hasilUjian ? $hasilUjian->nilai : 'Belum Ada Nilai',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Email',
            'Kelas',
            'Ujian',
            'Sudah Mengerjakan',
            'Nilai',
        ];
    }
}
