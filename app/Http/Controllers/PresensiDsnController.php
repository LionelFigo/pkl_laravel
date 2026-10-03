<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Pertemuan;
use App\Models\KelasMatkul;
use App\Models\Matkul;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PresensiDsnController extends Controller
{
    public function index($id_pertemuan){
        $pertemuan = Pertemuan::where('id', $id_pertemuan)->first();
        $kelas = KelasMatkul::where('id', $pertemuan->id_kelas)->first();
        $matkul = Matkul::where('kode_makul', $kelas->kode_makul)->first();
        $dosen = Dosen::where('nik', $kelas->nik)->first();
        $jurusan = Jurusan::where('kode_jurusan', $kelas->kode_jurusan)->first();

        $qr = QrCode::size(200)->generate($id_pertemuan);

        return view('dosen_kelas_presensi.index', compact('pertemuan', 'kelas', 'matkul', 'dosen', 'jurusan', 'qr'));
    }

    public function tabel($id_pertemuan){
        $presensi = Presensi::where('id_pertemuan', $id_pertemuan)->get();
        $nim = $presensi->pluck('nim');
        $mahasiswa = Mahasiswa::whereIn('nim', $nim)->pluck('nama','nim');

        foreach ($presensi as $p){
            $p->nama_mhs = $mahasiswa[$p->nim] ?? 'Nama Tidak Ditemukan';
        }

        return view ('dosen_kelas_presensi.tabel_presensi', compact('presensi'));
    }

    public function ubahStatus($id_pertemuan, $aksi){
        $pertemuan = Pertemuan::where('id', $id_pertemuan)->first();

        if(!$pertemuan){
            return redirect()->back()->with('error', 'Data Pertemuan Tidak Ditemukan');
        }

        if($aksi == 'tutup'){
            $pertemuan->status_presensi = 0;
            $pertemuan->save();
            return redirect()->back()->with('success', 'Berhasil Tutup Presensi');
        }elseif($aksi == 'buka'){
            $pertemuan->status_presensi = 1;
            $pertemuan->save();
            return redirect()->back()->with('success', 'Berhasil Buka Presensi');
        }

        return redirect()->back();
    }

    public function update(Request $request){
        $request->validate([
            'id_presensi' => 'required',
            'status' => 'required|in:h,i,s,a,d',
        ]);

        $presensi = Presensi::where('id', $request->id_presensi)->first();

        if(!$presensi){
            if($request->ajax()){
                return response()->json(['status' => false, 'message' => 'Data Presensi Tidak Ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Data Presensi Tidak Ditemukan');
        }

        $presensi->status_kehadiran = $request->status;
        $presensi->save();

        if($request->ajax()){
            return response()->json(['status' => true, 'message' => 'Berhasil Mengubah Status Kehadiran']);
        }

        return redirect()->back()->with('success', 'Berhasil Mengubah Status Kehadiran');
    }
}
