<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
}
