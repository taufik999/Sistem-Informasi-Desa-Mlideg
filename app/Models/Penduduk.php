<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $fillable = [
        'nik', 'nkk', 'nama', 'jk', 'tempat_lahir', 'tgl_lahir', 'alamat', 'dusun', 
        'kewarganegaraan', 'agama', 'status_kawin', 'pendidikan', 'pekerjaan', 'status'
    ];
}
