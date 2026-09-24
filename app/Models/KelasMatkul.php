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
}
