<?php

namespace App\Imports;

use App\Models\Periode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PeriodeImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */

    public function startRow():int{
        return 2;
    }

    public function collection(Collection $rows):void
    {
        foreach($rows as $row){
            $kode_akd = $row[1];
            $semester = $row[2];
            $tahun = $row[3];
            $status = $row[4];

            if(empty($kode_akd) || empty($semester) || empty($tahun) || empty($status)){
                continue;
            }

            $cek_periode = Periode::where('kode_akd', $kode_akd)->exists();

            $st = ($status == 'Aktif') ? '1' : '0';
            if(!$cek_periode){
                Periode::create([
                    'kode_akd' => $kode_akd,
                    'semester' => $semester,
                    'tahun' => $tahun,
                    'is_active' => $st,
                ]);
            }
        }
    }
}
