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

    public function kelasMatkul(){
        return $this->belongsTo(kelasMatkul::class, 'id_kelas', 'id');
    }
    
    public function presensi(){
        return $this->hasMany(Presensi::class, 'id_pertemuan', 'id');
    }
}
