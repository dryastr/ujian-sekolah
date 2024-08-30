<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;

class JurusanSiswaController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })
            ->orderByRaw('IF(jurusan_id IS NULL, 0, 1)') 
            ->get();

        return view('admin.admin.jurusan_siswa.index', compact('jurusans', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        User::create($request->all());

        return redirect()->route('jurusan_siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('jurusan_siswa.index')->with('success', 'Data siswa berhasil diubah.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('jurusan_siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
