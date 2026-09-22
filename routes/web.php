<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MatkulController;

// Login
Route::get('/',                    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',              [AuthController::class, 'login'])->name('login.post');
Route::post('/check-credentials',  [AuthController::class, 'checkCredentials'])->name('check.credentials');
Route::get('/logout',              [AuthController::class, 'logout'])->name('logout');

// Home — dilindungi middleware CheckAuth
Route::middleware('check.auth')->group(function () {
    Route::get('/home_mahasiswa', function () {
        return view('home_mahasiswa.index');
    })->name('home.mahasiswa');

    Route::get('/home_admin', [AdminController::class, 'index'])->name('home.admin');
    Route::get('/admin_data_administrator', [AdminController::class, 'dataAdministrator'])->name('admin.data_administrator');
    Route::post('/admin/user/tambah', [AdminController::class, 'storeUser'])->name('admin.user.store');
    Route::get('/admin/user/{id}/edit', [AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/admin/user/{id}/update', [AdminController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
    Route::get('/data_mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
    Route::post('/data_mahasiswa/tambah', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
    Route::get('/data_mahasiswa/hapus/{nim}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');
    Route::get('/data_mahasiswa/edit/{nim}', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
    
    Route::get('/data_dosen', [DosenController::class,'index'])->name('admin.dosen.index');

    Route::get('/data_matkul', [MatkulController::class, 'index'])->name('admin.matkul.index');
    Route::post('/data_makul/tambah', [MatkulController::class, 'store'])->name('admin.matkul.store');

    Route::get('/home_dosen', function () {
        return view('home_dosen.index');
    })->name('home.dosen');
});


