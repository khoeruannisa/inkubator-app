<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // Ambil kontrol (pastikan tidak null)
        $kontrol = DB::table('kontrol')
                        ->where('id', 1)
                        ->first();

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
                    ->paginate(50); // Paginate agar tidak overload

        return view('riwayat', compact('riwayat', 'tanggal'));
    }

    // ─── API GRAFIK (Dibatasi 100 data terakhir) ─────────────────
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