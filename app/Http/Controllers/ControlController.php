<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontrol;

class ControlController extends Controller
{
    // Menampilkan halaman kontrol
    public function index()
    {
        $kontrol = Kontrol::first();

        return view('kontrol', compact('kontrol'));
    }

    // Mengubah mode (Otomatis / Manual)
    public function updateMode(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:Otomatis,Manual',
        ]);

        $kontrol = Kontrol::first();

        $kontrol->update([
            'mode' => $request->mode,
        ]);

        return redirect()->back()->with('success', 'Mode berhasil diperbarui.');
    }

    // Mengontrol Heater
    public function heater(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::first();

        $kontrol->update([
            'heater' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status heater berhasil diperbarui.');
    }

    // Mengontrol Motor
    public function motor(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::first();

        $kontrol->update([
            'motor' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status motor berhasil diperbarui.');
    }

    // Mengontrol Kipas
    public function kipas(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::first();

        $kontrol->update([
            'kipas' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status kipas berhasil diperbarui.');
    }

    // Mengubah target suhu dan kelembapan
    public function parameter(Request $request)
    {
        $request->validate([
            'target_suhu' => 'required|numeric|min:30|max:45',
            'target_kelembapan' => 'required|integer|min:40|max:90',
        ]);

        $kontrol = Kontrol::first();

        $kontrol->update([
            'target_suhu' => $request->target_suhu,
            'target_kelembapan' => $request->target_kelembapan,
        ]);

        return redirect()->back()->with('success', 'Parameter berhasil diperbarui.');
    }
}