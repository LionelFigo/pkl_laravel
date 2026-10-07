<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_pertemuan',
        'nim',
        'status_kehadiran',
    ];

    public function pertemuan(){
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan', 'id');
    }

    public function mhs(){
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
