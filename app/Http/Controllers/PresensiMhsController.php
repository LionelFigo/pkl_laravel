<?php

namespace App\Http\Controllers;

use App\Models\Pertemuan;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiMhsController extends Controller
{
    public function index()
    {
        return view('mahasiswa_presensi.index');
    }

    public function prosesPresensi(Request $request)
    {
        if ($request->has('id_pertemuan')) {
            $id_pertemuan = $request->query('id_pertemuan') ?? $request->input('id_pertemuan');
            $nim = session('user')['username'] ?? null;

            $data_pertemuan = Pertemuan::where('id', $id_pertemuan)->first();
            $status_pertemuan = $data_pertemuan ? $data_pertemuan->status_presensi : 0;

            if ($status_pertemuan == 0) {
                return redirect()->route('mahasiswa.presensi')->with('error', 'Presensi Ditutup');
            } else {
                $data_status_hadir = Presensi::where('id_pertemuan', $id_pertemuan)->where('nim', $nim)->first();

                if (!$data_status_hadir) {
                    return redirect()->route('mahasiswa.presensi')->with('error', 'Anda tidak terdaftar pada presensi kelas ini');
                }

                $status_hadir = $data_status_hadir->status_kehadiran;

                if ($status_hadir == 'h') {
                    return redirect()->route('mahasiswa.presensi')->with('error', 'Anda Sudah Melakukan Absensi');
                } else {
                    $status_kehadiran = 'h';
                    $data_status_hadir->status_kehadiran = $status_kehadiran;
                    $data_status_hadir->save();

                    return redirect()->route('mahasiswa.presensi')->with('success', 'Berhasil Melakukan Absensi');
                }
            }
        }

        return redirect()->route('mahasiswa.presensi');
    }
}
