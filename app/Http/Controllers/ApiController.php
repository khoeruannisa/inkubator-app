<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontrol;
use App\Models\Sensor;

class ApiController extends Controller
{
    // ESP8266 mengambil parameter kontrol
    public function getKontrol()
    {
        return response()->json(Kontrol::first());
    }


    // ESP8266 mengirim data sensor
    public function updateSensor(Request $request)
    {
        $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan' => 'required|numeric'
        ]);


        Sensor::create([
    'suhu' => $request->suhu,
    'kelembapan' => $request->kelembapan,
    'heater' => $request->heater ?? 'OFF',
    'motor' => $request->motor ?? 'OFF'
]);


        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diterima'
        ]);
    }
}