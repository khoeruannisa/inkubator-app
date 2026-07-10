<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControlController;


// ─── ROOT ────────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect('/dashboard');
});

// ─── AUTH (Guest Only) ───────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',   [AuthController::class, 'showLogin']);
    Route::post('/login',  [AuthController::class, 'login']);

    Route::get('/register',  [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

// ─── LOGOUT (POST — aman dari CSRF) ─────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// ─── HALAMAN YANG BUTUH LOGIN ────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Riwayat
    Route::get('/riwayat', [DashboardController::class, 'riwayat']);

    // Halaman Kontrol
    Route::get('/kontrol',    [ControlController::class, 'index']);
    Route::post('/mode',      [ControlController::class, 'updateMode']);
    Route::post('/heater',    [ControlController::class, 'heater']);
    Route::post('/motor',     [ControlController::class, 'motor']);
    Route::post('/kipas',     [ControlController::class, 'kipas']);
    Route::post('/parameter', [ControlController::class, 'parameter']);

});
