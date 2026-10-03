<?php

namespace App\Http\Controllers;

use App\Models\KelasMatkul;
use App\Models\Periode;
use App\Imports\KelasImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KelasMatkulController extends Controller
{
    public function index(Request $request){
        $periode = Periode::all();

        $kelas = [];

        if($request->has('kode_akd')){
            $kelas = KelasMatkul::where('kode_akd', $request->kode_akd)->get();
        }

        return view('admin_kelas_matkul.index', compact('kelas', 'periode'));
    }

    public function store(Request $request){
        $cek = KelasMatkul::where('kode_akd', $request->kode_akd)->
                            where('kode_makul', $request->kode_makul)->
                            where('kode_jurusan', $request->kode_jurusan)->
                            where('nik', $request->nik)->
                            where('nama_kelas', $request->nama_kelas)
                            ->first();

        if($cek){
            return redirect()->back()->with('error', 'Kelas Sudah Ada');
        }else{
            KelasMatkul::create([
                'kode_akd' => $request->kode_akd,
                'kode_makul' => $request->kode_makul,
                'kode_jurusan' => $request->kode_jurusan,
                'nik' => $request->nik,
                'nama_kelas' => $request->nama_kelas,
            ]);

            return redirect()->back()->with('success', 'Berhasil Tambah Kelas');
        }
    }

    public function hapus($id){
        KelasMatkul::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Kelas Berhasil Dihapus');
    }

    public function edit($id){
        $kelas = KelasMatkul::where('id', $id)->first();

        return view('admin_kelas_matkul.edit', compact('kelas'));
    }

    public function update(Request $request, $id){
        $cek =  KelasMatkul::where('kode_akd', $request->kode_akd)->
                            where('kode_makul', $request->kode_makul)->
                            where('kode_jurusan', $request->kode_jurusan)->
                            where('nik', $request->nik)->
                            where('nama_kelas', $request->nama_kelas)
                            ->first();
        if($cek){
            return redirect()->back()->with('error', 'Kelas Tidak Boleh Sama');
        }else{
            KelasMatkul::where('id', $id)->update([
                'kode_akd' => $request->kode_akd,
                'kode_makul' => $request->kode_makul,
                'kode_jurusan' => $request->kode_jurusan,
                'nik' => $request->nik,
                'nama_kelas' => $request->nama_kelas,
            ]);

            return redirect()->route('admin.kelas.index', ['kode_akd' => $request->kode_akd])->with('success', 'Data Berhasil Diedit');
        }
    }
}
