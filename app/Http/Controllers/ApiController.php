<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontrol;
use App\Models\Sensor;
use App\Models\Inkubator;

class ApiController extends Controller
{
    // ESP8266 mengambil parameter kontrol
    public function getKontrol()
    {
        $kontrol = Kontrol::first();

        if (!$kontrol) {
            return response()->json([
                'mode'              => 'Otomatis',
                'heater'            => 'OFF',
                'motor'             => 'OFF',
                'kipas'             => 'OFF',
                'target_suhu'       => 37.5,
                'target_kelembapan' => 65,
            ]);
        }

        return response()->json($kontrol);
    }

    // ESP8266 mengirim data sensor
    // FIX BUG: simpan ke KEDUA tabel (sensors = realtime, inkubator = historis untuk grafik)
    public function updateSensor(Request $request)
    {
        $request->validate([
            'suhu'       => 'required|numeric',
            'kelembapan' => 'required|numeric',
        ]);

        $suhu       = $request->suhu;
        $kelembapan = $request->kelembapan;
        $heater     = $request->heater ?? 'OFF';
        $motor      = $request->motor  ?? 'OFF';

        // 1. Simpan ke tabel sensors (dipakai dashboard realtime & API /sensor)
        Sensor::create([
            'suhu'       => $suhu,
            'kelembapan' => $kelembapan,
            'heater'     => $heater,
            'motor'      => $motor,
        ]);

        // 2. Simpan ke tabel inkubator (dipakai grafik /api/suhu & riwayat)
        \DB::table('inkubator')->insert([
            'suhu'       => $suhu,
            'kelembapan' => $kelembapan,
            'status'     => 'Heater:' . $heater . ' Motor:' . $motor,
            'created_at' => now(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diterima',
        ]);
    }
}