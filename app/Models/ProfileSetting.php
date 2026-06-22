<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileSetting extends Model
{
    protected $fillable = [
        'sejarah',
        'geografis',
        'visi',
        'misi',
        'struktur_organisasi'
    ];
}
