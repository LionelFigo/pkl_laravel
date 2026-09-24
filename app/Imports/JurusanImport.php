<?php

namespace App\Imports;

use App\Models\Jurusan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class JurusanImport implements ToCollection, WithStartRow
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
            $kode_jrs = $row[1];
            $nama_jrs = $row[2];

            if(empty($kode_jrs) || empty($nama_jrs)){
                continue;
            }

            $cek_jrs = Jurusan::where('kode_jurusan', $kode_jrs)->exists();

            if(!$cek_jrs){
                Jurusan::create([
                    'kode_jurusan' => $kode_jrs,
                    'nama_jurusan' => $nama_jrs,
                ]);
            }
        }
    }
}
