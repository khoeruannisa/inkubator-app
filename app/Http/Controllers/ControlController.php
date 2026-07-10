<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontrol;

class ControlController extends Controller
{
    // ─── HALAMAN KONTROL ─────────────────────────────────────────
    public function index()
    {
        // Gunakan firstOrCreate agar tidak crash jika tabel kontrol kosong
        $kontrol = Kontrol::firstOrCreate(
            ['id' => 1],
            [
                'mode'              => 'Otomatis',
                'heater'            => 'OFF',
                'motor'             => 'OFF',
                'kipas'             => 'OFF',
                'target_suhu'       => 37.5,
                'target_kelembapan' => 65,
            ]
        );

        return view('kontrol', compact('kontrol'));
    }

    // ─── MODE OPERASI ─────────────────────────────────────────────
    public function updateMode(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:Otomatis,Manual',
        ]);

        $kontrol = Kontrol::findOrFail(1);
        $kontrol->update(['mode' => $request->mode]);

        return redirect()->back()->with('success', 'Mode berhasil diperbarui.');
    }

    // ─── KONTROL HEATER ──────────────────────────────────────────
    public function heater(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::findOrFail(1);
        $kontrol->update(['heater' => $request->status]);

        return redirect()->back()->with('success', 'Status heater berhasil diperbarui.');
    }

    // ─── KONTROL MOTOR ───────────────────────────────────────────
    public function motor(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::findOrFail(1);
        $kontrol->update(['motor' => $request->status]);

        return redirect()->back()->with('success', 'Status motor berhasil diperbarui.');
    }

    // ─── KONTROL KIPAS ───────────────────────────────────────────
    public function kipas(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::findOrFail(1);
        $kontrol->update(['kipas' => $request->status]);

        return redirect()->back()->with('success', 'Status kipas berhasil diperbarui.');
    }

    // ─── UBAH TARGET ─────────────────────────────────────────────
    public function parameter(Request $request)
    {
        $request->validate([
            'target_suhu'        => 'required|numeric|min:30|max:45',
            'target_kelembapan'  => 'required|integer|min:40|max:90',
        ]);

        $kontrol = Kontrol::findOrFail(1);
        $kontrol->update([
            'target_suhu'       => $request->target_suhu,
            'target_kelembapan' => $request->target_kelembapan,
        ]);

        return redirect()->back()->with('success', 'Parameter berhasil diperbarui.');
    }
}