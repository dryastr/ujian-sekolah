<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Ujian;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $kelasCount = Kelas::count();
        $jurusansCount = Jurusan::count();
        $ujianCount = Ujian::count();
        $siswaCount = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->count();
        $mataPelajaranCount = MataPelajaran::count();
        $guruCount = User::whereHas('role', function ($query) {
            $query->where('name', 'teacher');
        })->count();

        return view('admin.admin.dashboard', compact('kelasCount', 'jurusansCount', 'siswaCount', 'ujianCount', 'mataPelajaranCount', 'guruCount'));
    }
}
