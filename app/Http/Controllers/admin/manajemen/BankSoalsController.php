<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankSoalsController extends Controller
{
    public function index()
    {
        $bankSoals = BankSoal::with(['guru', 'mataPelajaran', 'tahunAjaran'])->get();
        $gurus = User::whereHas('role', function ($query) {
            $query->where('name', 'teacher');
        })->get();
        $mataPelajarans = MataPelajaran::all();
        $tahunAjarans = TahunAjaran::select('id', DB::raw("CONCAT(tahun_mulai, ' - ', tahun_selesai) as tahun"))
            ->get();
        return view('admin.teacher.bank_soal.index', compact('bankSoals', 'gurus', 'mataPelajarans', 'tahunAjarans'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        BankSoal::create($request->all());

        return redirect()->route('bank_soals.index')->with('success', 'Bank soal berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        $bankSoal = BankSoal::findOrFail($id);
        $bankSoal->update($request->all());

        return redirect()->route('bank_soals.index')->with('success', 'Bank soal berhasil diubah.');
    }

    public function destroy($id)
    {
        $bankSoal = BankSoal::findOrFail($id);
        $bankSoal->delete();

        return redirect()->route('bank_soals.index')->with('success', 'Bank soal berhasil dihapus.');
    }
}
