<?php

namespace App\Exports;

use App\Models\Jurusan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JurusanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    private $no = 1;

    public function collection(): Collection
    {
        return Jurusan::orderBy('kode_jurusan', 'asc')->get();
    }

    public function headings():array{
        return [
            'No',
            'Kode Jurusan',
            'Nama Jurusan'
        ];
    }

    public function map($jrs):array{
        return [
            $this->no++,
            $jrs->kode_jurusan,
            $jrs->nama_jurusan,
        ];
    }
}
