<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Nama tabel di database
    protected $table = 'user';

    // Primary key
    protected $primaryKey = 'id';

    // Tabel 'user' tidak memiliki kolom created_at dan updated_at
    public $timestamps = false;

    // Field yang boleh diisi
    protected $fillable = [
        'username',
        'password',
        'peran',
        'pin',
        'nama',
    ];

    // Sembunyikan password & pin dari JSON output
    protected $hidden = [
        'password',
        'pin',
    ];
}
