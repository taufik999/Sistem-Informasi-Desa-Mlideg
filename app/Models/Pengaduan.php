<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'track_id', 'nik', 'tanggal', 'nama', 'hp', 'dusun', 'kategori', 'subjek', 'pesan', 'foto', 'status', 'handled_by', 'ip_address', 'user_agent'
    ];
}
