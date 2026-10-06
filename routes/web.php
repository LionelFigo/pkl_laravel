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
use App\Http\Controllers\DetailKelasController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\MhsController;
use App\Http\Controllers\DsnController;
use App\Http\Controllers\PresensiMhsController;
use App\Http\Controllers\DetailkelasDsnController;
use App\Http\Controllers\PertemuanDsnController;
use App\Http\Controllers\PresensiDsnController;

// Login
Route::get('/',                    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',              [AuthController::class, 'login'])->name('login.post');
Route::post('/check-credentials',  [AuthController::class, 'checkCredentials'])->name('check.credentials');
Route::get('/logout',              [AuthController::class, 'logout'])->name('logout');

// Dilindungi middleware check.auth
Route::middleware('check.auth')->group(function () {

   
    Route::middleware('check.role:m')->group(function () {
        Route::get('/home_mahasiswa', [MhsController::class, 'index'])->name('home.mahasiswa');
        Route::get('/home_mhs', [MhsController::class, 'index'])->name('home.mhs');
        Route::get('/mahasiswa_presensi', [PresensiMhsController::class, 'index'])->name('mahasiswa.presensi');
        Route::match(['get', 'post'], '/mahasiswa_presensi/proses', [PresensiMhsController::class, 'prosesPresensi'])->name('mahasiswa.presensi.proses');
        Route::match(['get', 'post'], '/proses_presensi', [PresensiMhsController::class, 'prosesPresensi'])->name('proses.presensi');
    });

    Route::middleware('check.role:a')->group(function () {
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
        Route::get('/data_mahasiswa/ekspor', [MahasiswaController::class, 'eksporExcel'])->name('admin.mahasiswa.ekspor');
        Route::get('/data_mahasiswa/pdf', [MahasiswaController::class, 'pdf'])->name('admin.mahasiswa.pdf');
        
        Route::get('/data_dosen', [DosenController::class,'index'])->name('admin.dosen.index');
        Route::post('/data_dosen/tambah', [DosenController::class, 'store'])->name('admin.dosen.store');
        Route::get('/data_dosen/edit/{nik}', [DosenController::class, 'edit'])->name('admin.dosen.edit');
        Route::put('/data_dosen/update/{nik}', [DosenController::class, 'update'])->name('admin.dosen.update');
        Route::get('/data_dosen/hapus/{nik}', [DosenController::class, 'hapus'])->name('admin.dosen.hapus');
        Route::post('/data_dosen/foto', [DosenController::class, 'foto'])->name('admin.dosen.foto');
        Route::get('/data_dosen/reset', [DosenController::class, 'reset'])->name('admin.dosen.reset');
        Route::post('/data_dosen/impor', [DosenController::class, 'impor'])->name('admin.dosen.impor');
        Route::get('/data_dosen/ekspor', [DosenController::class, 'ekspor'])->name('admin.dosen.ekspor');
        Route::get('/data_dosen/pdf', [DosenController::class, 'pdf'])->name('admin.dosen.pdf');

        Route::get('/data_matkul', [MatkulController::class, 'index'])->name('admin.matkul.index');
        Route::post('/data_makul/tambah', [MatkulController::class, 'store'])->name('admin.matkul.store');
        Route::get('/data_matkul/hapus/{kode_makul}', [MatkulController::class, 'hapus'])->name('admin.matkul.hapus');
        Route::get('/data_matkul/edit/{kode_makul}', [MatkulController::class, 'edit'])->name('admin.matkul.edit');
        Route::put('/data_matkul/update/{kode_makul}', [MatkulController::class, 'update'])->name('admin.matkul.update');
        Route::get('/data_matkul/reset', [MatkulController::class, 'reset'])->name('admin.matkul.reset');
        Route::post('/data_matkul/impor', [MatkulController::class, 'impor'])->name('admin.matkul.impor');
        Route::get('/data_matkul/ekspor', [MatkulController::class, 'ekspor'])->name('admin.matkul.ekspor');
        Route::get('/data_matkul/pdf', [MatkulController::class, 'pdf'])->name('admin.matkul.pdf');

        Route::get('/data_periode', [PeriodeController::class, 'index'])->name('admin.periode.index');
        Route::post('/data_periode/store', [PeriodeController::class, 'store'])->name('admin.periode.store');
        Route::get('/data_periode/hapus/{kode_akd}', [PeriodeController::class, 'hapus'])->name('admin.periode.hapus');
        Route::get('/data_periode/edit/{kode_akd}', [PeriodeController::class, 'edit'])->name('admin.periode.edit');
        Route::put('/data_periode/update/{kode_akd}', [PeriodeController::class, 'update'])->name('admin.periode.update');
        Route::get('/data_periode/reset', [PeriodeController::class, 'reset'])->name('admin.periode.reset');
        Route::post('/data_periode/impor', [PeriodeController::class, 'impor'])->name('admin.periode.impor');
        Route::get('/data_periode/ekspor', [PeriodeController::class, 'ekspor'])->name('admin.periode.ekspor');
        Route::get('/data_periode/pdf', [PeriodeController::class, 'pdf'])->name('admin.periode.pdf');

        Route::get('/data_jurusan', [JurusanController::class, 'index'])->name('admin.jurusan.index');
        Route::post('/data_jurusan/store', [JurusanController::class, 'store'])->name('admin.jurusan.store');
        Route::get('/data_jurusan/hapus/{kode_jurusan}', [JurusanController::class, 'hapus'])->name('admin.jurusan.hapus');
        Route::get('/data_jurusan/edit/{kode_jurusan}', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
        Route::put('/data_jurusan/update/{kode_jurusan}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
        Route::get('/data_jurusan/reset', [JurusanController::class, 'reset'])->name('admin.jurusan.reset');
        Route::post('/data_jurusan/impor', [JurusanController::class, 'impor'])->name('admin.jurusan.impor');
        Route::get('/data_jurusan/ekspor', [JurusanController::class, 'ekspor'])->name('admin.jurusan.ekspor');
        Route::get('/data_jurusan/pdf', [JurusanController::class, 'pdf'])->name('admin.jurusan.pdf');

        Route::get('/data_kelas', [KelasMatkulController::class, 'index'])->name('admin.kelas.index');
        Route::post('/data_kelas/store', [KelasMatkulController::class, 'store'])->name('admin.kelas.store');
        Route::get('/data_kelas/hapus/{id}', [KelasMatkulController::class, 'hapus'])->name('admin.kelas.hapus');
        Route::get('/data_kelas/edit/{id}', [KelasMatkulController::class, 'edit'])->name('admin.kelas.edit');
        Route::put('/data_kelas/update/{id}', [KelasMatkulController::class, 'update'])->name('admin.kelas.update');
        Route::post('/data_kelas/impor', [KelasMatkulController::class, 'impor'])->name('admin.kelas.impor');

        Route::get('/data_detail/{id_kls_mk}', [DetailKelasController::class, 'index'])->name('admin.kelas.detail');
        Route::post('/data_detail/store', [DetailKelasController::class, 'store'])->name('admin.kelas.store_detail');
        Route::get('/data_detail/hapus_detail/{nim}/{id_kls_mk}', [DetailKelasController::class, 'hapus'])->name('admin.kelas.hapus_detail');
        Route::post('/data_detail/impor', [DetailKelasController::class, 'impor'])->name('admin.kelas.impor_detail');

        Route::get('/data_pertemuan/{id_kelas}', [PertemuanController::class, 'index'])->name('admin.kelas.pertemuan');
        Route::post('/data_pertemuan/store', [PertemuanController::class, 'store'])->name('admin.kelas.store_pertemuan');
        Route::post('/data_pertemuan/persen', [PertemuanController::class, 'editPersen'])->name('admin.kelas.persen');
        Route::get('/data_pertemuan/pdf/{id_kelas}', [PertemuanController::class, 'pdf'])->name('admin.kelas.pertemuan_pdf');

        Route::get('/data_presensi/{id_pertemuan}', [PresensiController::class, 'index'])->name('admin.kelas.presensi');
        Route::get('/data_presensi/tabel/{id_pertemuan}', [PresensiController::class, 'tabel'])->name('presensi.tabel');
        Route::post('/data_presensi/update', [PresensiController::class, 'update'])->name('presensi.update');
        Route::get('/data_presensi/{id_pertemuan}/{aksi}', [PresensiController::class, 'ubahStatus'])->name('presensi.ubah_status');

});    

     Route::middleware('check.role:d')->group(function () {
        Route::get('/home_dosen', [DsnController::class, 'index'])->name('home.dosen');
        Route::get('/dosen_kelas_matkul', [DsnController::class, 'kelasMatkul'])->name('dosen.kelas.index');

        Route::get('/dosen/pertemuan/{id_kelas}', [PertemuanDsnController::class, 'index'])->name('dosen.kelas.pertemuan');
        Route::post('/dosen/pertemuan/store', [PertemuanDsnController::class, 'store'])->name('dosen.kelas.pertemuan_store');

        Route::get('/dosen/detail_kelas/{id_kls_mk}', [DetailkelasDsnController::class, 'index'])->name('dosen.kelas.detail');
        Route::get('/dosen/detail_hapus/{nim}/{id_kls_mk}', [DetailkelasDsnController::class, 'hapus'])->name('dosen.kelas.hapus');
        Route::post('/dosen/detail/store', [DetailkelasDsnController::class, 'store'])->name('dosen.kelas.store');

        Route::get('/dosen/presensi/{id_pertemuan}', [PresensiDsnController::class, 'index'])->name('dosen.kelas.presensi');
        Route::get('/dosen/presensi/tabel/{id_pertemuan}', [PresensiDsnController::class, 'tabel'])->name('dosen.kelas.presensi_tabel');
        Route::get('/dosen/presensi/ubah_status/{id_pertemuan}/{aksi}', [PresensiDsnController::class, 'ubahStatus'])->name('dosen.kelas.presensi_ubah');
        Route::post('/dosen/presensi/update', [PresensiDsnController::class, 'update'])->name('dosen.presensi.update');
    });
});


