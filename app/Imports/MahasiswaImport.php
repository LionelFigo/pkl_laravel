<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MahasiswaImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */

    public function startRow():int{
        return 2;
    }

    public function collection(Collection $rows): void
    {
        foreach($rows as $row){
            $nim = $row[1];
            $nama = $row[2];
            $kontak = $row[3];
            $email = $row[4];
            $kelamin = $row[5];

            if(empty($nim) || empty($nama) || empty($kontak) || empty($email) || empty($kelamin)){
                continue;
            }

            $cek_mhs = Mahasiswa::where('nim', $nim)->exists();

            if(!$cek_mhs){
                Mahasiswa::create([
                    'nim' => $nim,
                    'nama' => $nama,
                    'kontak' => $kontak,
                    'email' => $email,
                    'kelamin' => $kelamin,
                ]);

                User::create([
                    'username' => $nim,
                    'password' => sha1($nim),
                    'peran' => 'm',
                    'pin' => sha1('123456'),
                    'nama' => $nama,
                ]);
            }
        }
    }
}