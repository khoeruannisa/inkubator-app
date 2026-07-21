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
        'target_kelembapan',
        'motor_last_on',
        'motor_interval_jam',
        'motor_durasi_menit',
    ];

    protected $casts = [
        'motor_last_on' => 'datetime',
    ];
}