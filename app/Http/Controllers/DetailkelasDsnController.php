<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\KelasMatkul;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DetailkelasDsnController extends Controller
{
    public function index($id_kls_mk){
        $detail = DetailKelas::with(['mhs'])->where('id_kls_mk', $id_kls_mk)->get();
        $kelas = KelasMatkul::with([
            'dosen',
            'jurusan',
            'periode',
            'matkul'
        ])->where('id', $id_kls_mk)->firstOrFail();
        $mahasiswa = Mahasiswa::all();

        return view('dosen_detail_kelas.index', compact('detail', 'kelas', 'mahasiswa'));
    }

    public function hapus($nim, $id_kls_mk){
        DetailKelas::where('nim', $nim)->where('id_kls_mk', $id_kls_mk)->delete();

        return redirect()->route('dosen.kelas.detail', $id_kls_mk)->with('success', 'Berhasil Hapus Mahasiswa');
    }

    public function store(Request $request){
        $cek = DetailKelas::where('id_kls_mk', $request->id_kls_mk)->where('nim', $request->nim)->exists();

        if($cek){
            return redirect()->back()->with('error', 'Mahasiswa Sudah Berada Dikelas Ini');
        }else{
            DetailKelas::create([
                'id_kls_mk' => $request->id_kls_mk,
                'nim' => $request->nim,
            ]);

            return redirect()->back()->with('success', 'Berhasil Menambah Mahasiswa');
        }
    }
}
