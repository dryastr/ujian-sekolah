<?php

namespace App\Exports;

use App\Models\HasilUjian;
use App\Models\JawabanSiswa;
use App\Models\Ujian;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HasilUjianExport implements FromCollection, WithHeadings, WithMapping
{
    protected $ujian;
    protected $siswa;
    protected $hasilUjian;
    protected $jawabanSiswa;

    public function __construct($ujian, $siswa, $hasilUjian, $jawabanSiswa)
    {
        $this->ujian = $ujian;
        $this->siswa = $siswa;
        $this->hasilUjian = $hasilUjian;
        $this->jawabanSiswa = $jawabanSiswa;
    }

    public function collection()
    {
        return $this->jawabanSiswa;
    }

    public function headings(): array
    {
        return [
            'Nama Ujian',
            'Nama Siswa',
            'Nilai',
            'No',
            'Soal',
            'Jawaban Benar',
            'Jawaban PG',
            'Jawaban Essay',
            'Status Benar',
        ];
    }

    public function map($jawaban): array
    {
        static $firstRow = true;

        $row = [
            $firstRow ? $this->ujian->name : '',
            $firstRow ? $this->siswa->name : '',
            $firstRow ? $this->hasilUjian->nilai : '',
            $jawaban->id,
            strip_tags($jawaban->soal->pertanyaan),
            strip_tags($jawaban->soal->jawaban_benar ?? $jawaban->soal->jawaban_essay),
            strip_tags($jawaban->jawaban ?? '-'),
            strip_tags($jawaban->jawaban_essay ?? '-'),
            $jawaban->status_benar ? 'Benar' : 'Salah',
        ];

        $firstRow = false;

        return $row;
    }
}
