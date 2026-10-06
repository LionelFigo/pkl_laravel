<?php

namespace App\Exports;

use App\Models\Dosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DosenExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    private $no = 1;

    public function collection(): Collection
    {
        return Dosen::orderBy('nik', 'asc')->get();
    }

    public function headings():array{
        return [
            'No',
            'NIK',
            'Nama Dosen',
            'Kontak',
            'Email',
            'Kelamin'
        ];
    }

    public function map($dosen):array{
        $kelamin = ($dosen->kelamin) == 'l' ? 'Laki-Laki' : 'Perempuan';

        return [
            $this->no++,
            $dosen->nik,
            $dosen->nama,
            $dosen->kontak,
            $dosen->email,
            $kelamin,
        ];
    }
}
