<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        return redirect()->back()->with('success', 'Data berhasil Dihapus');
    }

    public function edit($nim){
        $mahasiswa = Mahasiswa::findOrFail($nim);

        return view('admin_data_mahasiswa.edit', compact('mahasiswa'));
    }
    
}
