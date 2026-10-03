<?php

namespace App\Imports;

use App\Models\Periode;
use App\Models\Matkul;
use App\Models\Jurusan;
use App\Models\Dosen;
use App\Models\KelasMatkul;
use App\Models\DetailKelas;
use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelasImport implements ToCollection, WithStartRow
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
            $semester = $row[1];
            $tahun = $row[2];
            $mata_kuliah = $row[3];
            $dosen = $row[4];
            $jurusan = $row[5];
            $nama_kelas = $row[6];
            $mahasiswa = $row[7];

            if(empty($sems) || empty($thn) || empty($matkul) || empty($dosen) || empty($jrs) || empty($nama_kelas) || empty($mhs)){
                continue;
            }

            $periode = Periode::where('semester', $semester)->where('tahun', $tahun)->first();
            $matkul = Matkul::where('nama_makul', $mata_kuliah)->first();
            $dsn = Dosen::where('nama', $dosen)->first();
            $mhs = Mahasiswa::where('nama', $mahasiswa)->orWhere('nim', $mahasiswa)->first();

        }
    }
}
