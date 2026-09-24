<?php

namespace App\Http\Controllers;

use App\Models\KelasMatkul;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
}
