<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'akademik';
    protected $primaryKey = 'kode_akd';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'kode_akd',
        'semester',
        'tahun',
        'is_active',
    ];
}
