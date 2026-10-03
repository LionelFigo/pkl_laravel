<?php

namespace App\Http\Controllers;

use App\Models\Pertemuan;
use App\Models\KelasMatkul;
use App\Models\Presensi;
use App\Models\DetailKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PertemuanController extends Controller
{
    public function index($id_kelas){ 
        $pertemuan = Pertemuan::where('id_kelas', $id_kelas)->get();
        $kelas = KelasMatkul::where('id', $id_kelas)->first();

        return view('admin_kelas_pertemuan.index', compact('pertemuan', 'kelas'));
    }

    public function store(Request $request){
        $request->validate([
            'tanggal.after_or_equal' => 'Tanggal Minimal Hari Ini'
        ]);

        $id_kelas = $request->id_kelas;
        $pertemuan_terakhir = Pertemuan::where('id_kelas', $id_kelas)->max('pertemuan_ke') ?? 0;
        $pertemuan_ke = $pertemuan_terakhir + 1;

        $pertemuan = Pertemuan::create([
            'id_kelas' => $id_kelas,
            'tanggal' => $request->tanggal,
            'judul_pertemuan' => $request->judul_pertemuan,
            'status_presensi' => '1',
            'pertemuan_ke' => $pertemuan_ke,
        ]);

        $id_pertemuan = $pertemuan->id;

        $mahasiswa = DetailKelas::where('id_kls_mk', $id_kelas)->get();

        $data_presensi = [];
        foreach ($mahasiswa as $mhs){
            Presensi::create([
                'id_pertemuan' => $id_pertemuan,
                'nim' => $mhs->nim,
                'status_kehadiran' => 'a',
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Menambah Pertemuan');
    }
}
