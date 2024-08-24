<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaransController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::all();
        return view('admin.admin.tahun_ajaran.index', compact('tahunAjarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_mulai' => 'required|digits:4',
            'tahun_selesai' => 'required|digits:4',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        TahunAjaran::create($request->all());
        return redirect()->route('tahun-ajarans.index')->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'tahun_mulai' => 'required|digits:4',
            'tahun_selesai' => 'required|digits:4',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $tahunAjaran->update($request->all());
        return redirect()->route('tahun-ajarans.index')->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();
        return redirect()->route('tahun-ajarans.index')->with('success', 'Tahun Ajaran berhasil dihapus.');
    }
}
