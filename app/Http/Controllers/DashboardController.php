<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kontrol;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // ─── DASHBOARD ───────────────────────────────────────────────
    public function index()
    {
        // Data sensor terbaru dari tabel sensors (sumber utama real-time)
        $data = DB::table('sensors')
                    ->latest('id')
                    ->first();

        // 10 data terbaru untuk tabel di dashboard
        $list = DB::table('sensors')
                    ->orderBy('id', 'desc')
                    ->limit(10)
                    ->get();

        // FIX BUG #5: Gunakan firstOrCreate agar $kontrol tidak pernah null
        $kontrol = Kontrol::firstOrCreate(
            ['id' => 1],
            [
                'mode'               => 'Otomatis',
                'heater'             => 'OFF',
                'motor'              => 'OFF',
                'kipas'              => 'OFF',
                'target_suhu'        => 37.5,
                'target_kelembapan'  => 65,
                'motor_interval_jam' => 3,
                'motor_durasi_menit' => 5,
            ]
        );

        // Hitung usia telur berdasarkan data pertama di inkubator
        $start = DB::table('inkubator')
                    ->orderBy('created_at', 'asc')
                    ->first();

        $usia = $start
            ? Carbon::parse($start->created_at)->startOfDay()->diffInDays(now()->startOfDay()) + 1
            : 0;

        return view('dashboard', compact(
            'data',
            'kontrol',
            'usia',
            'list'
        ));
    }

    // ─── RIWAYAT ─────────────────────────────────────────────────
    public function riwayat(Request $request)
    {
        $tanggal = $request->tanggal;

        $query = DB::table('inkubator');

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $riwayat = $query
                    ->orderBy('created_at', 'desc')
                    ->paginate(50);

        return view('riwayat', compact('riwayat', 'tanggal'));
    }

    // ─── API GRAFIK (Dibatasi 100 data terakhir dari inkubator) ──
    public function grafik()
    {
        $data = DB::table('inkubator')
                    ->orderBy('created_at', 'desc')
                    ->limit(100)
                    ->get()
                    ->sortBy('created_at')
                    ->values();

        return response()->json($data);
    }
}