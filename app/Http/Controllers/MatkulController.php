<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use App\Imports\MatkulImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MatkulController extends Controller
{
    public function index(){
        $matkul = Matkul::all();
        return view('admin_data_matkul.index', compact('matkul'));
    }

    public function store(Request $request){
        $kode_makul = $request->kode_makul;

        $cek = Matkul::where('kode_makul', $kode_makul)->first();

        if($cek){
            return redirect()->back()->with('error', 'Data Sudah Ada');
        }else{
            Matkul::create([
                'kode_makul' => $request->kode_makul,
                'nama_makul' => $request->nama_makul,
                'jml_sks' => $request->jml_sks,
                'jml_cpmk' => $request->jml_cpmk,
            ]);

            return redirect()->back()->with('success', 'Berhasil Tambah Data');
        }
    }

    public function hapus($kode_makul){
        Matkul::where('kode_makul', $kode_makul)->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }

    public function edit($kode_makul){
        $matkul = Matkul::where('kode_makul', $kode_makul)->first();

        return view('admin_data_matkul.edit', compact('matkul'));
    }

    public function update(Request $request, $kode_makul){
        Matkul::where('kode_makul', $kode_makul)->update([
            'nama_makul' => $request->nama_makul,
            'jml_cpmk' => $request->jml_cpmk,
            'jml_sks' => $request->jml_sks,
        ]);

        return redirect()->route('admin.matkul.index')->with('success', 'Data Berhasil Diedit');
    }

    public function reset(){
        Matkul::truncate();

        return redirect()->back()->with('success', 'Data Berhasil Direset');
    }

    public function impor(Request $request){
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::Import(new MatkulImport, $request->file('file_excel'));

        return redirect()->back()->with('success', 'Berhasil Impor Data');
    }
}
