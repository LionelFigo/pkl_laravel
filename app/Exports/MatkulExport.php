<?php

namespace App\Exports;

use App\Models\Matkul;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MatkulExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    private $no = 1;

    public function collection(): Collection
    {
        return Matkul::orderBy('kode_makul', 'asc')->get();
    }

    public function headings():array{
        return [
            'No',
            'Kode Matkul',
            'Nama Matkul',
            'Jumlah SKS',
            'Jumlah CPMK',
        ];
    }

    public function map($matkul):array{
        return [
            $this->no++,
            $matkul->kode_makul,
            $matkul->nama_makul,
            $matkul->jml_sks,
            $matkul->jml_cpmk,
        ];
    }
}
