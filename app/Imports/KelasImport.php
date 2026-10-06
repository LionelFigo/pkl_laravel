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

            if(empty($semester) || empty($tahun) || empty($mata_kuliah) || empty($dosen) || empty($jurusan) || empty($nama_kelas) || empty($mahasiswa)){
                continue;
            }

            $periode = Periode::where('semester', $semester)->where('tahun', $tahun)->firstOrFail();
            $matkul = Matkul::where('nama_makul', $mata_kuliah)->firstOrFail();
            $dsn = Dosen::where('nama', $dosen)->firstOrFail();
            $jrs = Jurusan::where('nama_jurusan', $jurusan)->firstOrFail();
            $mhs = Mahasiswa::where('nama', $mahasiswa)->orWhere('nim', $mahasiswa)->firstOrFail();

            $cek = KelasMatkul::where('kode_akd', $periode->kode_akd)
                                ->where('kode_makul', $matkul->kode_makul)
                                ->where('kode_jurusan', $jrs->kode_jurusan)
                                ->where('nik', $dsn->nik)
                                ->where('nama_kelas', $nama_kelas)
                                ->first();
            if($cek){
                $cek_mhs = DetailKelas::where('id_kls_mk', $cek->id)->where('nim', $mhs->nim)->exists();
                if(!$cek_mhs){
                    DetailKelas::create([
                        'id_kls_mk' => $cek->id,
                        'nim' => $mhs->nim,
                    ]);
                }
            }else{
                $kelas = KelasMatkul::create([
                    'kode_akd' => $periode->kode_akd,
                    'kode_makul' => $matkul->kode_makul,
                    'kode_jurusan' => $jrs->kode_jurusan,
                    'nik' => $dsn->nik,
                    'nama_kelas' => $nama_kelas,
                ]);

                DetailKelas::create([
                    'id_kls_mk' => $kelas->id,
                    'nim' => $mhs->nim,
                ]);
            }
        }
    }
}
