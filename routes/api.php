<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\SensorController;

// API ESP8266
Route::get('/kontrol', [ApiController::class, 'getKontrol']);
Route::post('/sensor', [ApiController::class, 'updateSensor']);

// API Grafik Dashboard
Route::get('/suhu', [DashboardController::class, 'grafik']);

// Ambil data sensor untuk website
Route::get('/sensor', [SensorController::class, 'index']);