<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->get();
        $jurusans = Jurusan::all();
        return view('admin.admin.kelas.index', compact('kelas', 'jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diubah.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
