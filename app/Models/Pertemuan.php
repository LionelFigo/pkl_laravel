<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $table = 'pertemuan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_kelas',
        'tanggal',
        'judul_pertemuan',
        'status_presensi',
        'pertemuan_ke',
    ];
}
