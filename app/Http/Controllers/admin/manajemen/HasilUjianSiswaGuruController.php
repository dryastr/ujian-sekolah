<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Exports\HasilUjianExport;
use App\Exports\SiswaKelasExport;
use App\Http\Controllers\Controller;
use App\Models\HasilUjian;
use App\Models\JawabanSiswa;
use App\Models\Ujian;
use App\Models\User;
use App\Models\Kelas;
use App\Models\SiswaKelas;
use App\Models\Soal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HasilUjianSiswaGuruController extends Controller
{
    public function index()
    {
        $ujians = Ujian::all();
        return view('admin.teacher.hasil-ujians.index', compact('ujians'));
    }

    public function show($ujian_id)
    {
        $ujian = Ujian::findOrFail($ujian_id);
        $kelasList = Kelas::all();
        return view('admin.teacher.hasil-ujians.kelas-list', compact('ujian', 'kelasList'));
    }

    public function showKelas($ujian_id, $kelas_id)
    {
        $ujian = Ujian::findOrFail($ujian_id);
        $kelas = Kelas::findOrFail($kelas_id);

        $siswaKelas = SiswaKelas::with(['siswa' => function ($query) {
            $query->whereHas('role', function ($query) {
                $query->where('name', 'user');
            });
        }])->where('kelas_id', $kelas_id)->get();

        foreach ($siswaKelas as $siswaKelasItem) {
            $siswaKelasItem->sudah_mengerjakan = HasilUjian::where('ujian_id', $ujian_id)
                ->where('siswa_id', $siswaKelasItem->siswa_id)
                ->exists();
        }

        return view('admin.teacher.hasil-ujians.siswa-list', compact('ujian', 'kelas', 'siswaKelas'));
    }

    public function showHasil($ujian_id, $kelas_id, $siswa_id)
    {
        $ujian = Ujian::findOrFail($ujian_id);
        $kelas = Kelas::findOrFail($kelas_id);
        $siswa = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->findOrFail($siswa_id);

        $hasilUjian = HasilUjian::where('ujian_id', $ujian_id)
            ->where('siswa_id', $siswa_id)
            ->firstOrFail();

        $jawabanSiswa = JawabanSiswa::where('hasil_ujian_id', $hasilUjian->id)->get();

        return view('admin.teacher.hasil-ujians.hasil-detail', compact('ujian', 'kelas', 'siswa', 'hasilUjian', 'jawabanSiswa'));
    }

    public function updateStatusBenarUjianSiswa($id)
    {
        $jawaban = JawabanSiswa::findOrFail($id);

        if (!$jawaban->status_benar) {
            $jawaban->status_benar = true;
            $jawaban->save();

            $soal = Soal::findOrFail($jawaban->soal_id);

            $hasilUjian = HasilUjian::findOrFail($jawaban->hasil_ujian_id);
            $hasilUjian->nilai += $soal->point;
            $hasilUjian->save();
        }

        return redirect()->back()->with('success', 'Status jawaban berhasil diubah menjadi benar dan poin ditambahkan.');
    }

    public function updateStatusSalahUjianSiswa($id)
    {
        $jawaban = JawabanSiswa::findOrFail($id);

        if ($jawaban->status_benar) {
            $jawaban->status_benar = false;
            $jawaban->save();

            $soal = Soal::findOrFail($jawaban->soal_id);

            $hasilUjian = HasilUjian::findOrFail($jawaban->hasil_ujian_id);
            $hasilUjian->nilai -= $soal->point;
            $hasilUjian->save();
        }

        return redirect()->back()->with('success', 'Status jawaban berhasil diubah menjadi salah dan poin dikurangi.');
    }

    public function exportExcelListSiswa($ujian_id, $kelas_id)
    {
        return Excel::download(new SiswaKelasExport($ujian_id, $kelas_id), 'siswa_kelas.xlsx');
    }

    public function exportExcelResultStudents($ujian_id, $kelas_id, $siswa_id)
    {
        $ujian = Ujian::findOrFail($ujian_id);
        $siswa = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->findOrFail($siswa_id);

        $hasilUjian = HasilUjian::where('ujian_id', $ujian_id)
            ->where('siswa_id', $siswa_id)
            ->firstOrFail();

        $jawabanSiswa = JawabanSiswa::where('hasil_ujian_id', $hasilUjian->id)->get();

        return Excel::download(new HasilUjianExport($ujian, $siswa, $hasilUjian, $jawabanSiswa), 'hasil_ujian.xlsx');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
