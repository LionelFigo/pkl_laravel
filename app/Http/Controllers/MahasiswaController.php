<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Imports\MahasiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index(){
        $mahasiswa = Mahasiswa::all();
        return view('admin_data_mahasiswa.index', compact('mahasiswa'));
    }

    public function store(Request $request){
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim|max:10',
            'nama' => 'required|max:100',
            'kontak' => 'required|max:13',
            'email' => 'required|email|max:100',
            'kelamin' => 'required|in:l,p',
        ], [
            'nim.unique' => 'NIM Sudah Terdaftar',
        ]);

        DB::transaction(function () use ($request){
            Mahasiswa::create([
                'nim' => $request->nim,
                'nama' => $request->nama,
                'kontak' => $request->kontak,
                'email' => $request->email,
                'kelamin' => $request->kelamin,
            ]);

            User::create([
                'username' => $request->nim,
                'password' => Hash::make($request->nim),
                'peran' => 'm',
                'pin' => Hash::make('123456'),
                'nama' => $request->nama,
            ]);
        });

        return redirect()->back()->with('success', 'Data berhasil Ditambahkan');
    }

    public function destroy($nim){
        Mahasiswa::where('nim', $nim)->delete();
        User::where('username', $nim)->delete();

        return redirect()->back()->with('success', 'Data berhasil Dihapus');
    }

    public function edit($nim){
        $mahasiswa = Mahasiswa::findOrFail($nim);

        return view('admin_data_mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $nim){
        Mahasiswa::where('nim', $nim)->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'kelamin' => $request->kelamin,
        ]);

        User::where('username', $nim)->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Berhasil Diedit');
    }
    
    public function foto(Request $request){
       try {
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        if(!$mahasiswa){
            return redirect()->back()->with('error', 'Data Mahasiswa Tidak Ada');
        }

        if($request->hasFile('file_foto')){
            $file = $request->file('file_foto');
            $extension = $file->getClientOriginalExtension();
            $filename = 'foto-mhs' . round(microtime(true)) . '.' . $extension;

            $file->move(public_path('asset_web/img'), $filename);

            $alamat_tujuan = '../asset_web/img/' . $filename;

            $mahasiswa->update(['img' => $alamat_tujuan]);

            return redirect()->back()->with('success', 'Berhasil Upload Foto');
        }
       }catch(\Exception $e){
        return redirect()->back()->with('error', 'Terjadi Kesalahan :' . $e->getMessage());
       }
    }

    public function reset(){
        Mahasiswa::truncate();
        User::where('peran', 'm')->delete();

        return redirect()->back()->with('success', 'Data Berhasil DiReset');
    }

    public function impor(Request $request){
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new MahasiswaImport, $request->file('file_excel'));

        return redirect()->back()->with('success', 'Berhasil Impor Data');
    }
}
