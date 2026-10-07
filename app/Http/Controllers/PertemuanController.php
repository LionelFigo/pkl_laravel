<?php

namespace App\Http\Controllers;

use App\Models\Pertemuan;
use App\Models\KelasMatkul;
use App\Models\Presensi;
use App\Models\DetailKelas;
use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Periode;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PertemuanController extends Controller
{
    public function index($id_kelas){ 
        $pertemuan = Pertemuan::where('id_kelas', $id_kelas)->get();
        $kelas = KelasMatkul::with([
            'dosen',
            'periode',
            'jurusan',
            'matkul'
        ])->where('id', $id_kelas)->first();

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

        return redirect()->route('admin.kelas.presensi', $id_pertemuan)->with('success', 'Berhasil Menambah Pertemuan');
    }

    public function editPersen(Request $request){
        $id_kelas = $request->id_kelas;
        $persen = $request->persen;

        $kelas = KelasMatkul::find($id_kelas);
        $kelas->bobot_persen = $persen;
        $kelas->save();

        return redirect()->route('admin.kelas.pertemuan', $id_kelas)->with('success', 'Berhasil Edit Bobot Persen');
    }

    public function pdf($id_kelas){
        $kelas = KelasMatkul::where('id', $id_kelas)->first();
        $dosen = Dosen::where('nik', $kelas->nik)->first();
        $matkul = Matkul::where('kode_makul', $kelas->kode_makul)->first();
        $akd = Periode::where('kode_akd', $kelas->kode_akd)->first();
        $pertemuan = Pertemuan::where('id_kelas', $id_kelas)->pluck('id')->toArray();
        $jml_pertemuan = count($pertemuan);
        $detail = DetailKelas::where('id_kls_mk', $id_kelas)->get();

        $data_mhs = [];
        foreach ($detail as $d){
            $mhs = Mahasiswa::where('nim', $d->nim)->first();

            $jml_hadir = Presensi::where('nim', $d->nim)->where('status_kehadiran', 'h')->whereIn('id_pertemuan', $pertemuan)->count();
            $bobot = $kelas->bobot_persen ?? 0;
            $persen_kehadiran = ($jml_hadir / $jml_pertemuan) * 100;
            $nilai_kontrak = ($jml_hadir / $jml_pertemuan) * $bobot;

            $data_mhs[] = (object) [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'jml_hadir' => $jml_hadir,
                'persentase' => $persen_kehadiran,
                'nilai_kontrak' => $nilai_kontrak,
            ];
        }

        $data = [
            'kelas' => $kelas,
            'dosen' => $dosen,
            'matkul' => $matkul,
            'akd' => $akd,
            'jml_pertemuan' => $jml_pertemuan,
            'data_mhs' => $data_mhs,
        ];

        $pdf = Pdf::loadView('admin_kelas_pertemuan.pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('laporan_presensi.pdf');
    }

    public function pdf_presensi($id_kelas){
        $kelas = KelasMatkul::where('id', $id_kelas)->first();
        $dosen = Dosen::where('nik', $kelas->nik)->first();
        $matkul = Matkul::where('kode_makul', $kelas->kode_makul)->first();
        $akademik = Periode::where('kode_akd', $kelas->kode_akd)->first();
        $pertemuan = Pertemuan::where('id_kelas', $id_kelas)->with('presensi.mhs')->get();

        $data = [
            'kelas' => $kelas,
            'dosen' => $dosen,
            'matkul' => $matkul,
            'akd' => $akademik,
            'pertemuan' => $pertemuan,
        ];

        $pdf = Pdf::loadView('admin_kelas_pertemuan.pdf_absensi', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('laporan_absensi.pdf');
    }
}
