<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inkubator extends Model
{
    protected $table = 'inkubator';

    protected $fillable = [
        'suhu',
        'kelembapan',
        'status'
    ];

    public $timestamps = false;
}