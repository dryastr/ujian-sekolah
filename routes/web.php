<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\manajemen\AddUsersController;
use App\Http\Controllers\admin\manajemen\BankSoalsController;
use App\Http\Controllers\admin\manajemen\ChangeProfileTeacherController;
use App\Http\Controllers\admin\manajemen\GuruMataPelajaransController;
use App\Http\Controllers\admin\manajemen\HasilUjianSiswaGuruController;
use App\Http\Controllers\admin\manajemen\JurusansController;
use App\Http\Controllers\admin\manajemen\JurusanSiswaController;
use App\Http\Controllers\admin\manajemen\KelasController;
use App\Http\Controllers\admin\manajemen\MataPelajaransController;
use App\Http\Controllers\admin\manajemen\SiswaKelasController;
use App\Http\Controllers\admin\manajemen\SoalsController;
use App\Http\Controllers\admin\manajemen\TahunAjaransController;
use App\Http\Controllers\admin\manajemen\UjiansController;
use App\Http\Controllers\admin\TeacherController;
use App\Http\Controllers\ImageHandlerController;
use App\Http\Controllers\user\manajemen\ChangeProfileUserController;
use App\Http\Controllers\user\manajemen\HasilUjianSiswaController;
use App\Http\Controllers\user\manajemen\JawabanSiswaController;
use App\Http\Controllers\user\manajemen\JawabanSiswasController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role->name === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
    return redirect()->route('login');
})->name('home');

Auth::routes(['middleware' => ['redirectIfAuthenticated']]);


Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('add-users', AddUsersController::class);
    Route::resource('jurusans', JurusansController::class);
    Route::resource('mata-pelajarans', MataPelajaransController::class);
    Route::resource('tahun-ajarans', TahunAjaransController::class);
    Route::resource('guru-mata-pelajarans', GuruMataPelajaransController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('siswa-kelas', SiswaKelasController::class);
    Route::resource('ujians', UjiansController::class);
    Route::resource('jurusan_siswa', JurusanSiswaController::class);
    Route::get('/profile-admin/edit', [ChangeProfileTeacherController::class, 'edit'])->name('profile-admin.edit');
    Route::post('/profile-admin/update', [ChangeProfileTeacherController::class, 'update'])->name('profile-admin.update');
});

Route::middleware(['auth', 'role.teacher'])->group(function () {
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.dashboard');

    Route::resource('bank_soals', BankSoalsController::class);
    Route::post('/bank-soals/{id}/toggle-archived', [BankSoalsController::class, 'toggleArchived'])->name('bank_soals.toggleArchived');
    Route::resource('soals', SoalsController::class);
    Route::post('upload', [ImageHandlerController::class, 'store'])->name('upload.image');
    Route::delete('image-delete', [ImageHandlerController::class, 'remove'])->name('image.delete');
    Route::resource('hasil-ujian', HasilUjianSiswaGuruController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('hasil-ujian/{ujian}/kelas', [HasilUjianSiswaGuruController::class, 'show'])->name('hasil-ujian.kelas');
    Route::get('hasil-ujian/{ujian}/kelas/{kelas}', [HasilUjianSiswaGuruController::class, 'showKelas'])->name('hasil-ujian.kelas.siswa');
    Route::get('hasil-ujian/{ujian}/kelas/{kelas}/siswa/{siswa}', [HasilUjianSiswaGuruController::class, 'showHasil'])->name('hasil-ujian.kelas.siswa.hasil');
    Route::put('hasil-ujian/{id}/update-status-benar', [HasilUjianSiswaGuruController::class, 'updateStatusBenarUjianSiswa'])->name('hasil-ujian.update-status-benar');
    Route::put('hasil-ujian/{id}/update-status-salah', [HasilUjianSiswaGuruController::class, 'updateStatusSalahUjianSiswa'])->name('hasil-ujian.update-status-salah');
    Route::get('/export-excel/{ujian_id}/{kelas_id}', [HasilUjianSiswaGuruController::class, 'exportExcelListSiswa'])->name('export-list-siswa.excel');
    Route::get('/hasil-ujian/{ujian_id}/{kelas_id}/{siswa_id}/export', [HasilUjianSiswaGuruController::class, 'exportExcelResultStudents'])->name('hasil-ujian.export');
    Route::get('/profile-teacher/edit', [ChangeProfileTeacherController::class, 'edit'])->name('profile-teacher.edit');
    Route::post('/profile-teacher/update', [ChangeProfileTeacherController::class, 'update'])->name('profile-teacher.update');
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('home');

    Route::get('/ujian', [JawabanSiswasController::class, 'index'])->name('ujian.index');
    Route::get('/ujian/{ujian_id}/create', [JawabanSiswasController::class, 'create'])->name('ujian.create');
    Route::post('/ujian/{ujian_id}/store', [JawabanSiswasController::class, 'store'])->name('ujian.store');
    Route::get('/hasil-ujian-siswa', [HasilUjianSiswaController::class, 'index'])->name('hasil-ujian-siswa.index');
    Route::get('/hasil-ujian-siswa/{ujian_id}', [HasilUjianSiswaController::class, 'show'])->name('hasil-ujian-siswa.show');
    Route::get('profile-user/edit', [ChangeProfileUserController::class, 'edit'])->name('profile-user.edit');
    Route::post('profile-user/update', [ChangeProfileUserController::class, 'update'])->name('profile-user.update');
});
