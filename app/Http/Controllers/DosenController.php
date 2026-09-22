<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index(){
        $dosen = Dosen::All();
        return view('admin_data_dosen.index', compact('dosen'));
    }

    public function store(Request $request){
        $request->validate([
            'nik' => 'required|unique:dosen,nik|max:10',
            'nama' => 'required|max:100',
            'kontak' => 'required|max:13',
            'email' => 'required|email|max:100',
            'kelamin' => 'required|in:l,p',
        ],[
            'nik.unique' => 'NIK sudah Terdaftar',
        ]);

        DB::Transaction(function () use ($request){
            Dosen::create([
                'nik' => $request->nik,
                'nama' -> $request->nama,
                'kontak' => $request->kontak,
                'email' => $request->email,
                'kelamin' => $request->kelamin,
            ]);

            User::create([
                'username' => $request->nik,
                'password' => has::make($request->nik),
                'peran' => 'd',
                'pin' => hash::make('696969'),
                'nama' => $request->nama,
            ]);
        });

        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');    
    }
}
