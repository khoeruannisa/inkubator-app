<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // ==========================
    // DASHBOARD
    // ==========================
   public function index()
{
    $data = DB::table('inkubator')
                ->latest('id')
                ->first();

    $riwayat = DB::table('inkubator')
                    ->orderBy('id','desc')
                    ->get();

    $list = DB::table('inkubator')
                ->orderBy('id','desc')
                ->limit(10)
                ->get();

    $kontrol = DB::table('kontrol')
                    ->where('id',1)
                    ->first();

    $start = DB::table('inkubator')
                ->orderBy('created_at','asc')
                ->first();

    if($start){

        $usia = \Carbon\Carbon::parse($start->created_at)
                    ->startOfDay()
                    ->diffInDays(now()->startOfDay()) + 1;

    }else{

        $usia = 0;

    }

    return view('dashboard', compact(
        'data',
        'riwayat',
        'kontrol',
        'usia',
        'list'
    ));
}

    // ==========================
    // UPDATE SENSOR DARI WEBSITE
    // ==========================
    public function update(Request $request)
    {
        $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan' => 'required|numeric'
        ]);

        $kontrol = DB::table('kontrol')->where('id', 1)->first();

        $status = ($request->suhu < $kontrol->target_suhu)
            ? 'Pemanas ON'
            : 'Pemanas OFF';

        DB::table('inkubator')->insert([
            'suhu' => $request->suhu,
            'kelembapan' => $request->kelembapan,
            'status' => $status,
            'created_at' => now()
        ]);

        DB::table('kontrol')
            ->where('id', 1)
            ->update([
                'heater' => $status == 'Pemanas ON' ? 'ON' : 'OFF'
            ]);

        return back();
    }

    // ==========================
    // SIMPAN PARAMETER
    // ==========================
    public function simpanKontrol(Request $request)
    {
        DB::table('kontrol')->updateOrInsert(
            ['id' => 1],
            [
                'target_suhu' => $request->target_suhu,
                'target_kelembapan' => $request->target_kelembapan,
                'updated_at' => now()
            ]
        );

        DB::table('setting_log')->insert([
            'target_suhu' => $request->target_suhu,
            'target_kelembapan' => $request->target_kelembapan,
            'created_at' => now()
        ]);

        return redirect('/kontrol')
            ->with('success', 'Parameter berhasil disimpan');
    }

    // ==========================
    // API UNTUK ESP8266
    // ==========================
    public function getKontrol()
    {
        return response()->json(
            DB::table('kontrol')
                ->where('id', 1)
                ->first()
        );
    }

    // ==========================
    // PUTAR TELUR
    // ==========================
    public function putarTelur()
    {
        DB::table('kontrol')
            ->where('id', 1)
            ->update([
                'motor' => 'ON'
            ]);

        return back()->with('success', 'Motor berhasil dijalankan');
    }

    // ==========================
    // RIWAYAT
    // ==========================
    public function riwayat(Request $request)
    {
        $tanggal = $request->tanggal;

        $query = DB::table('inkubator');

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $riwayat = $query
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('riwayat', compact('riwayat', 'tanggal'));
    }

    // ==========================
    // LOGIN
    // ==========================
    public function login()
    {
        if (!session('login')) {
            return redirect('/login');
        }

        return redirect('/dashboard');
    }

public function grafik()
{
    $data = DB::table('inkubator')
                ->orderBy('created_at', 'asc')
                ->get();

    return response()->json($data);
}
}