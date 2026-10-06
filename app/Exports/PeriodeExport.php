<?php

namespace App\Exports;

use App\Models\Periode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PeriodeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    private $no = 1;

    public function collection(): Collection
    {
        return Periode::orderBy('kode_akd', 'asc')->get();
    }

    public function headings():array{
        return [
            'No',
            'Kode Akademik',
            'Semester',
            'Tahun',
        ];
    }

    public function map($periode):array{
        $semester = ($periode->semester) == 'GL' ? 'Ganjil' : 'Genap';

        return [
            $this->no++,
            $periode->kode_akd,
            $semester,
            $periode->tahun,
        ];
    }

}
