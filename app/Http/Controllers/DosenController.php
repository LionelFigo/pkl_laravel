<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Imports\DosenImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::All();

        return view('admin_data_dosen.index', compact('dosen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:dosen,nik|max:10',
            'nama' => 'required|max:100',
            'kontak' => 'required|max:13',
            'email' => 'required|email|max:100',
            'kelamin' => 'required|in:l,p',
        ], [
            'nik.unique' => 'NIK sudah Terdaftar',
        ]);

        DB::Transaction(function () use ($request) {
            Dosen::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'kontak' => $request->kontak,
                'email' => $request->email,
                'kelamin' => $request->kelamin,
            ]);

            User::create([
                'username' => $request->nik,
                'password' => Hash::make($request->nik),
                'peran' => 'd',
                'pin' => Hash::make('696969'),
                'nama' => $request->nama,
            ]);
        });

        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($nik)
    {
        $dosen = Dosen::where('nik', $nik)->firstOrFail();

        return view('admin_data_dosen.edit', compact('dosen'));
    }

    public function update(Request $request, $nik)
    {
        Dosen::where('nik', $nik)->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'kelamin' => $request->kelamin,
        ]);

        User::where('username', $nik)->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.dosen.index')->with('success', 'Data Berhasil Diedit');
    }

    public function hapus($nik)
    {
        Dosen::where('nik', $nik)->delete();
        User::where('username', $nik)->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }

    public function foto(Request $request)
    {
        try {
            $dosen = Dosen::findorFail($request->nik);

            if (! $dosen) {
                return redirect()->back()->with('error', 'Data Dosen Tidak Ada');
            }

            if ($request->hasFile('file_foto')) {
                $file = $request->file('file_foto');
                $extension = $file->getClientOriginalExtension();
                $filename = 'foto-dosen'.round(microtime(true)).'.'.$extension;

                $file->move(public_path('asset_web/img'), $filename);

                $alamat_tujuan = '../asset_web/img/'.$filename;

                Dosen::where('nik', $request->nik)->update(['img' => $alamat_tujuan]);

                return redirect()->back()->with('success', 'Berhasil Upload Foto');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan :'.$e->getMessage());
        }
    }

    public function reset(){
        Dosen::truncate();
        User::where('peran', 'd')->delete();

        return redirect()->back()->with('success', 'Data Berhasil Direset');
    }

    public function impor(Request $request){
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new DosenImport, $request->file('file_excel'));

        return redirect()->back()->with('success', 'Berhasil Impor Data');
    }
}
