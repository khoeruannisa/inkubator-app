<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sensor;

class SensorController extends Controller
{
    /**
     * Ambil data sensor terbaru untuk ditampilkan di dashboard website.
     */
    public function index()
    {
        $sensor = Sensor::latest()->first();

        if (!$sensor) {
            return response()->json([
                'suhu'       => 0,
                'kelembapan' => 0,
                'heater'     => 'OFF',
                'motor'      => 'OFF',
            ]);
        }

        return response()->json($sensor);
    }
}