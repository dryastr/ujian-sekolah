<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\manajemen\AddUsersController;
use App\Http\Controllers\admin\manajemen\BankSoalsController;
use App\Http\Controllers\admin\manajemen\GuruMataPelajaransController;
use App\Http\Controllers\admin\manajemen\JurusansController;
use App\Http\Controllers\admin\manajemen\KelasController;
use App\Http\Controllers\admin\manajemen\MataPelajaransController;
use App\Http\Controllers\admin\manajemen\SiswaKelasController;
use App\Http\Controllers\admin\manajemen\SoalsController;
use App\Http\Controllers\admin\manajemen\TahunAjaransController;
use App\Http\Controllers\admin\manajemen\UjiansController;
use App\Http\Controllers\admin\TeacherController;
use App\Http\Controllers\ImageHandlerController;
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
});

Route::middleware(['auth', 'role.teacher'])->group(function () {
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.dashboard');

    Route::resource('bank_soals', BankSoalsController::class);
    Route::resource('soals', SoalsController::class);
    Route::post('upload', [ImageHandlerController::class, 'store'])->name('upload.image');
    Route::delete('image-delete', [ImageHandlerController::class, 'remove'])->name('image.delete');
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('home');

    // Route untuk daftar ujian
    Route::get('/ujian', [JawabanSiswasController::class, 'index'])->name('ujian.index');

    // Route untuk form ujian
    Route::get('/ujian/{ujian_id}/create', [JawabanSiswasController::class, 'create'])->name('ujian.create');
    Route::post('/ujian/{ujian_id}/store', [JawabanSiswasController::class, 'store'])->name('ujian.store');
});
