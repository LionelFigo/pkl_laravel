<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Imports\JurusanImport;
use App\Exports\JurusanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class JurusanController extends Controller
{
    public function index(){
        $jurusan = Jurusan::all();

        return view('admin_data_jurusan.index', compact('jurusan'));
    }

    public function store(Request $request){
        $cek = Jurusan::where('kode_jurusan', $request->kode_jurusan)->first();
        
        if($cek){
            return redirect()->back()->with('error', 'Data Jurusan Sudah Ada');
        }else{
            Jurusan::create([
                'kode_jurusan' => $request->kode_jurusan,
                'nama_jurusan' => $request->nama_jurusan,
            ]);

            return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
        }
    }

    public function hapus($kode_jurusan){
        Jurusan::where('kode_jurusan', $kode_jurusan)->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }

    public function edit($kode_jurusan){
        $jurusan = Jurusan::where('kode_jurusan', $kode_jurusan)->firstOrFail();

        return view('admin_data_jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $kode_jurusan){
        Jurusan::where('kode_jurusan', $kode_jurusan)->update([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('admin.jurusan.index')->with('success', 'Data Berhasil Diedit');
    }

    public function reset(){
        Jurusan::truncate();

        return redirect()->back()->with('success', 'Berhasil Reset Data');
    }

    public function impor(Request $request){
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new JurusanImport, $request->file('file_excel'));

        return redirect()->back()->with('success', 'Berhasil impor Data');
    }

    public function pdf(){
        $jurusan = Jurusan::orderBy('kode_jurusan', 'asc')->get();

        $pdf = Pdf::loadView('admin_data_jurusan.pdf', compact('jurusan'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Data_Jurusan.pdf');
    }

    public function ekspor(){
        return Excel::download(new JurusanExport, 'Data_Jurusan.xlsx');
    }
}
