<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $fillable = [
        'track_id', 'tanggal', 'nik', 'nama', 'jenis', 'keperluan', 'status', 'dokumen_pendukung'
    ];
}
