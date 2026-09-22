<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'nama',
        'kontak',
        'email',
        'kelamin',
        'img',
    ];

   public function getImgAttribute($value)
    {
        if (!$value) {
            return null;
        }

        // Hapus titik dan slash di awal string (misal: "../", "./", atau "/")
        return ltrim($value, './');
    }
}
