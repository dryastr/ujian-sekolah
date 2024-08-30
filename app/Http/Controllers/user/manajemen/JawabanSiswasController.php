<?php

namespace App\Http\Controllers\user\manajemen;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\HasilUjian;
use App\Models\JawabanSiswa;
use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Http\Request;

class JawabanSiswasController extends Controller
{
    public function index()
    {
        $ujians = Ujian::all();
        return view('user.ujians.index', compact('ujians'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($ujian_id)
    {
        $ujian = Ujian::findOrFail($ujian_id);

        $bankSoals = BankSoal::where('ujian_id', $ujian_id)->where('is_archived', false)->get();

        $soals = Soal::whereIn('bank_soal_id', $bankSoals->pluck('id'))->get();

        return view('user.ujians.create', compact('soals', 'ujian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $ujian_id)
    {
        $user = auth()->user();

        $request->validate([
            'jawaban.*' => 'nullable',
        ]);

        $hasilUjian = HasilUjian::create([
            'ujian_id' => $ujian_id,
            'siswa_id' => $user->id,
            'nilai' => 0,
        ]);

        $totalPoints = 0;

        foreach ($request->jawaban as $soal_id => $jawaban) {
            $soal = Soal::find($soal_id);

            if ($soal->jenis_soal === 'pg') {
                $statusBenar = $soal->jawaban_benar === $jawaban;

                JawabanSiswa::create([
                    'hasil_ujian_id' => $hasilUjian->id,
                    'soal_id' => $soal_id,
                    'jawaban' => $jawaban,
                    'jawaban_essay' => null,
                    'status_benar' => $statusBenar,
                ]);

                if ($statusBenar) {
                    $totalPoints += $soal->point;
                }
            } elseif ($soal->jenis_soal === 'essay') {
                JawabanSiswa::create([
                    'hasil_ujian_id' => $hasilUjian->id,
                    'soal_id' => $soal_id,
                    'jawaban' => null,
                    'jawaban_essay' => $jawaban,
                    'status_benar' => 0,
                ]);
            }
        }

        $hasilUjian->update(['nilai' => $totalPoints]);

        return redirect()->route('ujian.index')->with('success', 'Hasil Ujian berhasil disimpan.');
    }
}
