<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrol extends Model
{
    protected $table = 'kontrol';

    protected $fillable = [
        'mode',
        'heater',
        'motor',
        'kipas',
        'target_suhu',
        'target_kelembapan'
    ];
}