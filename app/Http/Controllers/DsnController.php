<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KelasMatkul;
use App\Models\Periode;
use Illuminate\Http\Request;

class DsnController extends Controller
{
    public function index(){
        return view('home_dosen.index');
    }

    public function kelasMatkul(Request $request){
        $nik = session('user')['username'];
        $periode = Periode::all();

        $kelas = [];

        if($request->has('kode_akd')){
            $kelas = KelasMatkul::where('kode_akd', $request->kode_akd)->where('nik', $nik)->get();
        }

        return view('dosen_kelas_matkul.index', compact('kelas', 'periode'));
    }

}
