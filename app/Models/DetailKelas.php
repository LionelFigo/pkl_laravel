<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKelas extends Model
{
    protected $table = 'detail_kelas_makul';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_kls_mk',
        'nim',
    ];
}
