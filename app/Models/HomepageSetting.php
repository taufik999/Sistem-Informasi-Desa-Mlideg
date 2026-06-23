<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'sambutan_nama',
        'sambutan_jabatan',
        'sambutan_judul',
        'sambutan_konten',
        'sambutan_foto'
    ];
}
