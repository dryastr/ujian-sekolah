<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\SiswaKelas;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswaKelas = SiswaKelas::with(['siswa', 'kelas', 'tahunAjaran'])->get();

        // Ambil role siswa berdasarkan nama
        $siswa = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', 'user')
            ->pluck('users.name', 'users.id');

        $kelas = Kelas::pluck('name', 'id');
        $tahunAjaran = TahunAjaran::select('id', DB::raw("CONCAT(tahun_mulai, ' - ', tahun_selesai) as tahun"))
            ->pluck('tahun', 'id');

        return view('admin.admin.siswa_kelas.index', compact('siswaKelas', 'siswa', 'kelas', 'tahunAjaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        SiswaKelas::create($request->all());

        return redirect()->route('siswa-kelas.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiswaKelas $siswaKelas, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        $siswaKelas = SiswaKelas::findOrFail($id);
        $siswaKelas->update($request->all());

        return redirect()->route('siswa-kelas.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiswaKelas $siswaKelas)
    {
        $siswaKelas->delete();

        return redirect()->route('siswa-kelas.index')->with('success', 'Data berhasil dihapus.');
    }
}
