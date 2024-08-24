<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\GuruMataPelajaran;
use App\Models\MataPelajaran;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class GuruMataPelajaransController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacherRoleId = Role::where('name', 'teacher')->pluck('id')->first();
        $guruMataPelajarans = GuruMataPelajaran::with(['guru', 'mataPelajaran'])->get();
        $gurus = User::where('role_id', $teacherRoleId)->pluck('name', 'id');
        $mataPelajarans = MataPelajaran::pluck('name', 'id');
        return view('admin.admin.guru_mata_pelajarans.index', compact('guruMataPelajarans', 'gurus', 'mataPelajarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show create form
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        ]);

        GuruMataPelajaran::create($request->all());

        return redirect()->route('guru-mata-pelajarans.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Show details
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuruMataPelajaran $guruMataPelajaran)
    {
        // Show edit form
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuruMataPelajaran $guruMataPelajaran)
    {
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        ]);

        $guruMataPelajaran->update($request->all());

        return redirect()->route('guru-mata-pelajarans.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuruMataPelajaran $guruMataPelajaran)
    {
        $guruMataPelajaran->delete();

        return redirect()->route('guru-mata-pelajarans.index')->with('success', 'Data berhasil dihapus.');
    }
}
