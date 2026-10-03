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
}
