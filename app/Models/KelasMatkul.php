<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasMatkul extends Model
{
    protected $table = 'kelas_makul';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'kode_akd',
        'kode_makul',
        'kode_jurusan',
        'nik',
        'nama_kelas',
        'bobot_persen',
    ];

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'nik', 'nik');
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'kode_jurusan', 'kode_jurusan');
    }

    public function periode(){
        return $this->belongsTo(Periode::class, 'kode_akd', 'kode_akd');
    }

    public function matkul(){
        return $this->belongsTo(Matkul::class, 'kode_makul', 'kode_makul');
    }
}
