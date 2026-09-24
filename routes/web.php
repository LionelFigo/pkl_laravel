<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasMatkulController;

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

Route::middleware(CheckRole::class. ':a')->group(function(){
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
    Route::put('/data_mahasiswa/update/{nim}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
    Route::post('/data_mahasiswa/foto', [MahasiswaController::class, 'foto'])->name('admin.mahasiswa.foto');
    Route::get('/data_mahasiswa/reset', [MahasiswaController::class, 'reset'])->name('admin.mahasiswa.reset');
    Route::post('/data_mahasiswa/impor', [MahasiswaController::class, 'impor'])->name('admin.mahasiswa.impor');
    
    Route::get('/data_dosen', [DosenController::class,'index'])->name('admin.dosen.index');
    Route::post('/data_dosen/tambah', [DosenController::class, 'store'])->name('admin.dosen.store');
    Route::get('/data_dosen/edit/{nik}', [DosenController::class, 'edit'])->name('admin.dosen.edit');
    Route::put('/data_dosen/update/{nik}', [DosenController::class, 'update'])->name('admin.dosen.update');
    Route::get('/data_dosen/hapus/{nik}', [DosenController::class, 'hapus'])->name('admin.dosen.hapus');
    Route::post('/data_dosen/foto', [DosenController::class, 'foto'])->name('admin.dosen.foto');
    Route::get('/data_dosen/reset', [DosenController::class, 'reset'])->name('admin.dosen.reset');
    Route::post('/data_dosen/impor', [DosenController::class, 'impor'])->name('admin.dosen.impor');

    Route::get('/data_matkul', [MatkulController::class, 'index'])->name('admin.matkul.index');
    Route::post('/data_makul/tambah', [MatkulController::class, 'store'])->name('admin.matkul.store');
    Route::get('/data_matkul/hapus/{kode_makul}', [MatkulController::class, 'hapus'])->name('admin.matkul.hapus');
    Route::get('/data_matkul/edit/{kode_makul}', [MatkulController::class, 'edit'])->name('admin.matkul.edit');
    Route::put('/data_matkul/update/{kode_makul}', [MatkulController::class, 'update'])->name('admin.matkul.update');
    Route::get('/data_matkul/reset', [MatkulController::class, 'reset'])->name('admin.matkul.reset');
    Route::post('/data_matkul/impor', [MatkulController::class, 'impor'])->name('admin.matkul.impor');

    Route::get('/data_periode', [PeriodeController::class, 'index'])->name('admin.periode.index');
    Route::post('/data_periode/store', [PeriodeController::class, 'store'])->name('admin.periode.store');
    Route::get('/data_periode/hapus/{kode_akd}', [PeriodeController::class, 'hapus'])->name('admin.periode.hapus');
    Route::get('/data_periode/edit/{kode_akd}', [PeriodeController::class, 'edit'])->name('admin.periode.edit');
    Route::put('/data_periode/update/{kode_akd}', [PeriodeController::class, 'update'])->name('admin.periode.update');
    Route::get('/data_periode/reset', [PeriodeController::class, 'reset'])->name('admin.periode.reset');
    Route::post('/data_periode/impor', [PeriodeController::class, 'impor'])->name('admin.periode.impor');

    Route::get('/data_jurusan', [JurusanController::class, 'index'])->name('admin.jurusan.index');
    Route::post('/data_jurusan/store', [JurusanController::class, 'store'])->name('admin.jurusan.store');
    Route::get('/data_jurusan/hapus/{kode_jurusan}', [JurusanController::class, 'hapus'])->name('admin.jurusan.hapus');
    Route::get('/data_jurusan/edit/{kode_jurusan}', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
    Route::put('/data_jurusan/update/{kode_jurusan}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
    Route::get('/data_jurusan/reset', [JurusanController::class, 'reset'])->name('admin.jurusan.reset');
    Route::post('/data_jurusan/impor', [JurusanController::class, 'impor'])->name('admin.jurusan.impor');

    Route::get('/data_kelas', [KelasMatkulController::class, 'index'])->name('admin.kelas.index');

});    

    Route::get('/home_dosen', function () {
        return view('home_dosen.index');
    })->name('home.dosen');
});


