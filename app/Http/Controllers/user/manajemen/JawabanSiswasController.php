<?php

namespace App\Http\Controllers\user\manajemen;

use App\Http\Controllers\Controller;
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
        $soals = Soal::where('ujian_id', $ujian_id)->get();
        $ujian = Ujian::findOrFail($ujian_id);

        return view('user.ujians.create', compact('soals', 'ujian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $ujian_id)
    {
        $user = auth()->user();

        $request->validate([
            'jawaban.*' => 'required|in:A,B,C,D',
        ]);

        $hasilUjian = HasilUjian::create([
            'ujian_id' => $ujian_id,
            'siswa_id' => $user->id,
            'nilai' => 0,
        ]);

        $totalPoints = 0;

        foreach ($request->jawaban as $soal_id => $jawaban) {
            $soal = Soal::find($soal_id);
            $statusBenar = $soal->jawaban_benar === $jawaban;

            JawabanSiswa::create([
                'hasil_ujian_id' => $hasilUjian->id,
                'soal_id' => $soal_id,
                'jawaban' => $jawaban,
                'status_benar' => $statusBenar,
            ]);

            if ($statusBenar) {
                $totalPoints += $soal->point;
            }
        }

        $hasilUjian->update(['nilai' => $totalPoints]);

        return redirect()->route('ujian.index')->with('success', 'Jawaban berhasil disimpan.');
    }
}
