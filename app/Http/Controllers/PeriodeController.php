<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Imports\PeriodeImport;
use App\Exports\PeriodeExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PeriodeController extends Controller
{
    public function index(){
        $periode = Periode::all();

        return view('admin_data_periode.index', compact('periode'));
    }

    public function store(Request $request){
        $cek = Periode::where('kode_akd', $request->kode_akd)->first();
        
        if($cek){
            return redirect()->back()->with('error', 'Data Sudah Ada');
        }else{
            Periode::create([
                'kode_akd' => $request->kode_akd,
                'semester' => $request->semester,
                'tahun' => $request->tahun,
                'is_active' => $request->is_active,
            ]);

            return redirect()->back()->with('success', 'Berhasil Tambah');
        }
    }

    public function hapus($kode_akd){
        Periode::where('kode_akd', $kode_akd)->delete();

        return redirect()->route('admin.periode.index')->with('success', 'Data Berhasil Dihapus');
    }

    public function edit($kode_akd){
        $periode = Periode::where('kode_akd', $kode_akd)->firstOrFail();

        return view('admin_data_periode.edit', compact('periode'));
    }

    public function update(Request $request, $kode_akd){
        Periode::where('kode_akd', $kode_akd)->update([
            'semester' => $request->semester,
            'tahun' => $request->tahun,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.periode.index')->with('success', 'Data Berhasil Diedit');
    }

    public function reset(){
        Periode::truncate();

        return redirect()->back()->with('success', 'Data Berhasil DiReset');
    }

    public function impor(Request $request){
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PeriodeImport, $request->file('file_excel'));
        
        return redirect()->back()->with('success', 'Berhasil Impor Data');
    }

    public function pdf(){
        $periode = Periode::orderBy('kode_akd', 'asc')->get();

        $pdf = Pdf::loadView('admin_data_periode.pdf', compact('periode'));
        $pdf->setPaper('A4', 'Portrait');

        return $pdf->stream('Data_Akademik.pdf');
    }

    public function ekspor(){
        return Excel::download(new PeriodeExport, 'Data_Periode.xlsx');
    }
}
