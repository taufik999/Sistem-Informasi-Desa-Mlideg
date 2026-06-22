<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatDesa extends Model
{
    protected $fillable = ['nama', 'jabatan', 'level', 'deskripsi', 'icon', 'ttl', 'pendidikan', 'no_hp', 'urutan'];
}
