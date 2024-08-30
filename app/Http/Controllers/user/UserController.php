<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Ujian;
use App\Models\HasilUjian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Menghitung total ujian
        $totalUjian = Ujian::count();

        // Menghitung jumlah ujian yang sudah dikerjakan
        $ujianDikerjakan = HasilUjian::where('siswa_id', $user->id)->count();

        // Menghitung jumlah ujian yang belum dikerjakan
        $ujianBelumDikerjakan = $totalUjian - $ujianDikerjakan;

        // Mendapatkan tanggal selama 1 minggu terakhir
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

        // Mendapatkan nilai ujian selama 1 minggu terakhir
        $nilaiMingguan = HasilUjian::where('siswa_id', $user->id)
            ->whereDate('created_at', '>=', Carbon::now()->subWeek())
            ->selectRaw('DATE(created_at) as tanggal, SUM(nilai) as total_nilai')
            ->groupBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        // Menyusun data nilai dengan tanggal dan nilai default 0 jika tidak ada data
        $nilaiMingguanFormatted = $dates->map(function ($date) use ($nilaiMingguan) {
            return [
                'tanggal' => $date,
                'total_nilai' => $nilaiMingguan->has($date) ? $nilaiMingguan->get($date)->total_nilai : 0
            ];
        });

        // Mengirim data ke view
        return view('user.dashboard', [
            'totalUjian' => $totalUjian,
            'ujianDikerjakan' => $ujianDikerjakan,
            'ujianBelumDikerjakan' => $ujianBelumDikerjakan,
            'nilaiMingguan' => $nilaiMingguanFormatted
        ]);
    }
}
