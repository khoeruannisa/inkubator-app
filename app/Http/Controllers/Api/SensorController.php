<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sensor;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        $sensor = Sensor::create([
            'suhu' => $request->suhu,
            'kelembapan' => $request->kelembapan
        ]);

        return response()->json([
            'status' => 'berhasil',
            'data' => $sensor
        ]);
    }

    public function index()
    {
        return Sensor::latest()->first();
    }
}