<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kontrol;
use Carbon\Carbon;

class ControlController extends Controller
{
    // ─── HALAMAN KONTROL ─────────────────────────────────────────
    public function index()
    {
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

        return redirect()->back()->with('success', 'Mode berhasil diperbarui ke: ' . $request->mode);
    }

    // ─── KONTROL HEATER ──────────────────────────────────────────
    public function heater(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::findOrFail(1);
        $kontrol->update(['heater' => $request->status]);

        return redirect()->back()->with('success', 'Heater berhasil ' . ($request->status === 'ON' ? 'dinyalakan.' : 'dimatikan.'));
    }

    // ─── KONTROL MOTOR ───────────────────────────────────────────
    public function motor(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::findOrFail(1);

        $updateData = ['motor' => $request->status];

        // Catat waktu saat motor dinyalakan untuk timeline
        if ($request->status === 'ON') {
            $updateData['motor_last_on'] = now();
        }

        $kontrol->update($updateData);

        return redirect()->back()->with('success', 'Motor berhasil ' . ($request->status === 'ON' ? 'dinyalakan.' : 'dimatikan.'));
    }

    // ─── KONTROL KIPAS ───────────────────────────────────────────
    public function kipas(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ON,OFF',
        ]);

        $kontrol = Kontrol::findOrFail(1);
        $kontrol->update(['kipas' => $request->status]);

        return redirect()->back()->with('success', 'Kipas berhasil ' . ($request->status === 'ON' ? 'dinyalakan.' : 'dimatikan.'));
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

    // ─── UBAH JADWAL PUTAR OTOMATIS ──────────────────────────────
    public function jadwalMotor(Request $request)
    {
        $request->validate([
            'motor_interval_jam'  => 'required|integer|min:1|max:12',
            'motor_durasi_menit'  => 'required|integer|min:1|max:60',
        ]);

        $kontrol = Kontrol::findOrFail(1);
        $kontrol->update([
            'motor_interval_jam' => $request->motor_interval_jam,
            'motor_durasi_menit' => $request->motor_durasi_menit,
        ]);

        return redirect()->back()->with('success', 'Jadwal putar motor berhasil diperbarui.');
    }

    // ─── API: TIMELINE LOG PUTAR MOTOR (Manual) ──────────────────
    // Baca perubahan status motor dari tabel sensors untuk ditampilkan sebagai timeline
    public function motorTimeline()
    {
        // Ambil 50 record terakhir dari sensors, cari perubahan status motor
        $sensors = DB::table('sensors')
                        ->orderBy('id', 'desc')
                        ->limit(200)
                        ->get(['id', 'motor', 'created_at']);

        $timeline = [];
        $prevStatus = null;
        $onTime = null;

        // Balik urutan agar dari lama ke baru
        $sensors = $sensors->reverse()->values();

        foreach ($sensors as $sensor) {
            $currentStatus = $sensor->motor;

            if ($prevStatus === null) {
                $prevStatus = $currentStatus;
                if ($currentStatus === 'ON') {
                    $onTime = $sensor->created_at;
                }
                continue;
            }

            // Motor baru dinyalakan
            if ($prevStatus === 'OFF' && $currentStatus === 'ON') {
                $onTime = $sensor->created_at;
            }

            // Motor baru dimatikan — catat sesi
            if ($prevStatus === 'ON' && $currentStatus === 'OFF' && $onTime) {
                $start    = Carbon::parse($onTime);
                $end      = Carbon::parse($sensor->created_at);
                $duration = $start->diffInSeconds($end);

                $timeline[] = [
                    'on'       => $onTime,
                    'off'      => $sensor->created_at,
                    'durasi_s' => $duration,
                    'durasi'   => $this->formatDurasi($duration),
                ];

                $onTime = null;
            }

            $prevStatus = $currentStatus;
        }

        // Jika motor masih ON sekarang, tambahkan sesi yang belum selesai
        if ($prevStatus === 'ON' && $onTime) {
            $start    = Carbon::parse($onTime);
            $duration = $start->diffInSeconds(now());

            $timeline[] = [
                'on'       => $onTime,
                'off'      => null,
                'durasi_s' => $duration,
                'durasi'   => $this->formatDurasi($duration),
            ];
        }

        // Balik lagi agar terbaru di atas
        $timeline = array_reverse($timeline);

        return response()->json([
            'timeline' => array_slice($timeline, 0, 20),
            'kontrol'  => Kontrol::first(['motor', 'motor_last_on', 'motor_interval_jam', 'motor_durasi_menit']),
        ]);
    }

    private function formatDurasi(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . ' detik';
        }
        $menit = intdiv($seconds, 60);
        $sisa  = $seconds % 60;
        if ($menit < 60) {
            return $menit . ' mnt ' . ($sisa > 0 ? $sisa . ' dtk' : '');
        }
        $jam = intdiv($menit, 60);
        $m   = $menit % 60;
        return $jam . ' jam ' . ($m > 0 ? $m . ' mnt' : '');
    }
}