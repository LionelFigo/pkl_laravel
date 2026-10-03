<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\KelasMatkul;
use App\Models\Mahasiswa;
use App\Imports\DetailKelasImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DetailKelasController extends Controller
{
    public function index($id_kls_mk){
        $kelas = KelasMatkul::with([
            'dosen',
            'jurusan',
            'periode'
        ])->where('id', $id_kls_mk)->firstOrFail();
        $detail = DetailKelas::with(['mhs'])->where('id_kls_mk', $id_kls_mk)->get();
        $mahasiswa = Mahasiswa::all();

        return view('admin_detail_kelas.index', compact('detail', 'kelas', 'mahasiswa'));
    }

    public function hapus($nim, $id_kls_mk){
        DetailKelas::where('nim', $nim)->where('id_kls_mk', $id_kls_mk)->delete();

        return redirect()->route('admin.kelas.detail', $id_kls_mk)->with('success', 'Berhasil Hapus Mahasiswa');
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

    public function impor(Request $request){
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        $id_kelas = $request->id_kelas;
        Excel::import(new DetailKelasImport($id_kelas), $request->file('file_excel'));

        return redirect()->back()->with('success', 'Berhasil Impor Mahasiswa');
    }
}
