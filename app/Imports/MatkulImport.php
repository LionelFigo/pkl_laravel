<?php

namespace App\Imports;

use App\Models\Matkul;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MatkulImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */

    public function startRow():int{
        return 2;
    }

    public function collection(Collection $rows):void
    {
        foreach ($rows as $row){
            $kode_makul = $row[1];
            $nama_makul = $row[2];
            $jml_sks = $row[3];
            $jml_cpmk = $row[4];

            if(empty($kode_makul) || empty($nama_makul) || empty($jml_sks) || empty($jml_cpmk)){
                continue;
            }

            $cek_makul = Matkul::where('kode_makul', $kode_makul)->exists();

            if(!$cek_makul){
                Matkul::create([
                    'kode_makul' => $kode_makul,
                    'nama_makul' => $nama_makul,
                    'jml_sks' => $jml_sks,
                    'jml_cpmk' => $jml_cpmk,
                ]);
            }
        }
    }
}
