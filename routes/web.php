<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControlController;


// ROOT
Route::get('/', function () {
    return redirect('/dashboard');
});

// LOGIN
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

// REGISTER
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// LOGOUT
Route::get('/logout', [AuthController::class, 'logout']);

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index']);

// HALAMAN KONTROL
Route::get('/kontrol', [ControlController::class, 'index']);
Route::post('/mode', [ControlController::class, 'updateMode']);
Route::post('/heater', [ControlController::class, 'heater']);
Route::post('/motor', [ControlController::class, 'motor']);
Route::post('/kipas', [ControlController::class, 'kipas']);
Route::post('/parameter', [ControlController::class, 'parameter']);

// RIWAYAT
Route::get('/riwayat', [DashboardController::class, 'riwayat']);



