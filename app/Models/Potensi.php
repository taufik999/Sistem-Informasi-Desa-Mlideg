<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Potensi extends Model
{
    protected $fillable = [
        'judul', 'kategori', 'deskripsi', 'full_desc', 'foto', 'is_url'
    ];
}
