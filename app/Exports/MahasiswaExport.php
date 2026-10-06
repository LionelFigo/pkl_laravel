<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MahasiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    private $no = 1;

    public function collection(): Collection
    {
        return Mahasiswa::orderBy('nim', 'asc')->get();
    }

    public function headings(): array{
        return [
            'No',
            'NIM',
            'Nama Mahasiswa',
            'Kontak',
            'Email',
            'Jenis Kelamin'
        ];
    }

    public function map($mahasiswa): array{
        $kelamin = ($mahasiswa->kelamin) == 'l' ? 'Laki-Laki' : 'Perempuan';

        return [
            $this->no++,
            $mahasiswa->nim,
            $mahasiswa->nama,
            $mahasiswa->kontak,
            $mahasiswa->email,
            $kelamin,
        ];
    }
}
