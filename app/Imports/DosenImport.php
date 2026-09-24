<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DosenImport implements ToCollection, WithStartRow
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
            $nik = $row[1];
            $nama = $row[2];
            $kontak = $row[3];
            $email = $row[4];
            $kelamin = $row[5];

            if(empty($nik) || empty($nama) || empty($kontak) || empty($email) || empty($kelamin)){
                contine;
            }

            $cek_dosen = Dosen::where('nik', $nik)->exists();

            if(!$cek_dosen){
                Dosen::create([
                    'nik' => $nik,
                    'nama' => $nama,
                    'kontak' => $kontak,
                    'email' => $email,
                    'kelamin' => $kelamin,
                ]);

                User::create([
                    'username' => $nik,
                    'password' => sha1($nik),
                    'peran' => 'd',
                    'pin' => sha1('696969'),
                    'nama' => $nama,
                ]);
            }
        }
    }
}
