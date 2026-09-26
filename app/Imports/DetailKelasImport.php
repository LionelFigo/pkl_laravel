<?php

namespace App\Imports;

use App\Models\DetailKelas;
use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\StartWithRow;

class DetailKelasImport implements ToCollection, StartWithRow
{
    /**
    * @param Collection $collection
    */

    public function startRow():int{
        return 2;
    }

    protected $id_kelas;

    public function __construct($id_kelas){
        $this->id_kelas = $id_kelas;
    }

    public function collection(Collection $rows):void
    {
        foreach ($rows as $row){
            $data = $row[1];

            if(empty($data)){
                continue;
            }

            if(Mahasiswa::where('nim', $data)->first()){
                $nim = $data;

                $cek = DetailKelas::where('id_kls_mk', $this->id_kelas)->where('nim', $nim)->exists();
                if(!$cek){
                    DetailKelas::create([
                        'id_kls_mk' => $this->id_kelas,
                        'nim' => $nim,
                    ]);
                }
            }else{
                $mhs = Mahasiswa::where('nama', $data)->first();
            }
        }
    }
}
