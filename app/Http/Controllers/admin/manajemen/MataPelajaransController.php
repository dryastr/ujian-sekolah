<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class MataPelajaransController extends Controller
{
    public function index()
    {
        $mataPelajarans = MataPelajaran::with('jurusan')->get();
        $jurusans = Jurusan::all();
        return view('admin.admin.mata_pelajaran.index', compact('mataPelajarans', 'jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        MataPelajaran::create($request->all());

        return redirect()->route('mata-pelajarans.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->update($request->all());

        return redirect()->route('mata-pelajarans.index')->with('success', 'Mata Pelajaran berhasil diubah.');
    }

    public function destroy($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()->route('mata-pelajarans.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}
