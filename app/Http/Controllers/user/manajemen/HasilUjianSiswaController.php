<?php

namespace App\Http\Controllers\user\manajemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\HasilUjian;
use App\Models\JawabanSiswa;
use Illuminate\Support\Facades\Auth;

class HasilUjianSiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua ujian
        $ujians = Ujian::all();

        // Ambil hasil ujian yang sudah dikerjakan oleh siswa
        $hasilUjian = HasilUjian::where('siswa_id', $user->id)->pluck('ujian_id')->toArray();

        return view('user.hasil_ujian.index', compact('ujians', 'hasilUjian'));
    }

    // Menampilkan detail hasil ujian
    public function show($ujian_id)
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Ambil ujian yang sesuai dengan ujian_id
        $ujian = Ujian::findOrFail($ujian_id);

        // Ambil hasil ujian berdasarkan ujian_id dan siswa_id
        $hasilUjian = HasilUjian::where('ujian_id', $ujian_id)
            ->where('siswa_id', $user->id)
            ->firstOrFail();

        // Ambil semua jawaban siswa berdasarkan hasil ujian
        $jawabanSiswa = JawabanSiswa::where('hasil_ujian_id', $hasilUjian->id)->get();

        // Ambil nilai dari tabel hasil_ujians
        $nilaiTotal = $hasilUjian->nilai;

        return view('user.hasil_ujian.show', compact('ujian', 'hasilUjian', 'jawabanSiswa', 'nilaiTotal'));
    }
}
