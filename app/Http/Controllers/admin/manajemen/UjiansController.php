<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\User;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UjiansController extends Controller
{
    public function index()
    {
        $ujian = Ujian::all();
        $gurus = User::whereHas('role', function ($query) {
            $query->where('name', 'teacher');
        })->pluck('name', 'id');
        $mataPelajarans = MataPelajaran::pluck('name', 'id');
        $kelas = Kelas::pluck('name', 'id');
        $tahunAjarans = TahunAjaran::select('id', DB::raw("CONCAT(tahun_mulai, ' - ', tahun_selesai) as tahun"))
            ->pluck('tahun', 'id');

        return view('admin.admin.ujian.index', compact('ujian', 'gurus', 'mataPelajarans', 'kelas', 'tahunAjarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        Ujian::create($request->all());

        return redirect()->route('ujians.index')->with('success', 'Ujian created successfully.');
    }

    public function update(Request $request, Ujian $ujian)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        // Mengupdate data ujian
        $ujian->update($request->all());

        return redirect()->route('ujians.index')->with('success', 'Ujian updated successfully.');
    }

    public function destroy(Ujian $ujian)
    {
        $ujian->delete();

        return redirect()->route('ujians.index')->with('success', 'Ujian deleted successfully.');
    }
}
