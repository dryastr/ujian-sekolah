<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HasilUjian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        // Count total students with role 'user'
        $totalSiswa = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->count();

        // Count students who have completed at least one exam
        $siswaYangSudahUjian = HasilUjian::distinct('siswa_id')->count('siswa_id');

        // Count students who have not completed any exam
        $siswaYangBelumUjian = $totalSiswa - $siswaYangSudahUjian;

        // Count students with scores above 75
        $siswaNilaiDiatas75 = HasilUjian::where('nilai', '>', 75)
            ->distinct('siswa_id')
            ->count('siswa_id');

        // Get data for the past week
        $dateStart = Carbon::now()->subDays(6);
        $weeklyData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $dateStart->copy()->addDays($i);
            $weeklyData[$date->format('Y-m-d')] = [
                'sudah_ujian' => HasilUjian::whereDate('created_at', $date->format('Y-m-d'))->distinct('siswa_id')->count('siswa_id'),
                'belum_ujian' => $totalSiswa - HasilUjian::whereDate('created_at', $date->format('Y-m-d'))->distinct('siswa_id')->count('siswa_id'),
            ];
        }

        return view('admin.teacher.dashboard', compact(
            'totalSiswa',
            'siswaYangSudahUjian',
            'siswaYangBelumUjian',
            'siswaNilaiDiatas75',
            'weeklyData'
        ));
    }
}
