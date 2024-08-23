<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\manajemen\AddUsersController;
use App\Http\Controllers\admin\manajemen\JurusansController;
use App\Http\Controllers\admin\manajemen\MataPelajaransController;
use App\Http\Controllers\admin\TeacherController;
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
});

Route::middleware(['auth', 'role.teacher'])->group(function () {
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.dashboard');
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');
});

// Contoh
// Route::get('/', function () {
//     if (Auth::check()) {
//         $user = Auth::user();
//         if ($user->role->name === 'super_admin') {
//             return redirect()->route('super_admin.dashboard');
//         } elseif ($user->role->name === 'admin') {
//             return redirect()->route('admin.dashboard');
//         } elseif ($user->role->name === 'kaprog') {
//             return redirect()->route('kaprog.dashboard');
//         } elseif ($user->role->name === 'pemray') {
//             return redirect()->route('pemray.dashboard');
//         } else {
//             return redirect()->route('home');
//         }
//     }
//     return redirect()->route('login');
// })->name('home');
