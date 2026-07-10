@extends('layout')

@section('content')

<h4 class="mb-4 fw-bold">📊 Dashboard</h4>

<style>
    #chart {
        width: 100% !important;
        height: 380px !important;
    }
</style>

{{-- ─── KARTU STATUS ─────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- SUHU --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-danger">
            <small class="opacity-75">🌡️ Suhu Saat Ini</small>
            <h3 class="mt-1 mb-0" id="suhu">{{ $data->suhu ?? 0 }} °C</h3>
        </div>
    </div>

    {{-- KELEMBAPAN --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-primary">
            <small class="opacity-75">💧 Kelembapan</small>
            <h3 class="mt-1 mb-0" id="kelembapan">{{ $data->kelembapan ?? 0 }} %</h3>
        </div>
    </div>

    {{-- USIA TELUR --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-warning text-dark">
            <small class="opacity-75">🥚 Usia Telur</small>
            <h3 class="mt-1 mb-0">{{ $usia }} Hari</h3>
        </div>
    </div>

    {{-- STATUS HEATER --}}
    <div class="col-md-3 col-6">
        <div class="card-box {{ ($kontrol->heater ?? 'OFF') == 'ON' ? 'bg-success' : 'bg-secondary' }}">
            <small class="opacity-75">🔥 Heater</small>
            <h3 class="mt-1 mb-0" id="heater">{{ $kontrol->heater ?? 'OFF' }}</h3>
        </div>
    </div>

    {{-- MOTOR --}}
    <div class="col-md-3 col-6">
        <div class="card-box" style="background: linear-gradient(135deg,#7b2ff7,#9b59ff);">
            <small class="opacity-75">⚙️ Motor Putar</small>
            <h3 class="mt-1 mb-0" id="motorStatus">{{ $kontrol->motor ?? 'OFF' }}</h3>
            <small id="motorInfo" class="opacity-75">Menunggu...</small>
        </div>
    </div>

    {{-- TARGET SUHU --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-dark">
            <small class="opacity-75">🎯 Target Suhu</small>
            <h3 class="mt-1 mb-0">{{ $kontrol->target_suhu ?? 37.5 }} °C</h3>
        </div>
    </div>

    {{-- TARGET KELEMBAPAN --}}
    <div class="col-md-3 col-6">
        <div class="card-box" style="background:#0891b2;">
            <small class="opacity-75">🎯 Target Kelembapan</small>
            <h3 class="mt-1 mb-0">{{ $kontrol->target_kelembapan ?? 65 }} %</h3>
        </div>
    </div>

    {{-- MODE --}}
    <div class="col-md-3 col-6">
        <div class="card-box" style="background:#059669;">
            <small class="opacity-75">🔧 Mode</small>
            <h3 class="mt-1 mb-0">{{ $kontrol->mode ?? 'Otomatis' }}</h3>
        </div>
    </div>

</div>

{{-- ─── GRAFIK ───────────────────────────────────────────── --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3">📈 Grafik Suhu & Kelembapan (100 Data Terakhir)</h5>
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ─── TABEL DATA TERBARU ───────────────────────────────── --}}
<div class="card">
    <div class="card-header bg-dark text-white">
        <h6 class="mb-0">📋 10 Data Sensor Terbaru</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Suhu (°C)</th>
                    <th>Kelembapan (%)</th>
                    <th>Heater</th>
                    <th>Motor</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($list as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->suhu }}</td>
                    <td>{{ $item->kelembapan ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $item->heater == 'ON' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $item->heater ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ ($item->motor ?? 'OFF') == 'ON' ? 'bg-primary' : 'bg-secondary' }}">
                            {{ $item->motor ?? '-' }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada data sensor. Menunggu data dari perangkat...
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ─── SCRIPTS ──────────────────────────────────────────── --}}
<script>
let chart;

function loadChart() {
    fetch('/api/suhu')
        .then(res => res.json())
        .then(data => {
            const labels      = [];
            const suhuData    = [];
            const lembapData  = [];

            data.forEach(item => {
                const waktu = new Date(item.created_at);
                labels.push(waktu.toLocaleTimeString('id-ID'));
                suhuData.push(parseFloat(item.suhu));
                lembapData.push(parseFloat(item.kelembapan));
            });

            if (chart) chart.destroy();

            chart = new Chart(document.getElementById('chart'), {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Suhu (°C)',
                            data: suhuData,
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239,68,68,0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                        },
                        {
                            label: 'Kelembapan (%)',
                            data: lembapData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59,130,246,0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    scales: { y: { beginAtZero: false } },
                    plugins: { legend: { position: 'top' } },
                },
            });
        });
}

// ─── Realtime sensor update ───────────────────────────────
function loadRealtime() {
    fetch('/api/sensor')
        .then(res => res.json())
        .then(data => {
            document.getElementById('suhu').textContent       = data.suhu + ' °C';
            document.getElementById('kelembapan').textContent = data.kelembapan + ' %';
            document.getElementById('heater').textContent     = data.heater;
        })
        .catch(() => {}); // Jangan crash jika API lambat

    fetch('/api/kontrol')
        .then(res => res.json())
        .then(data => {
            document.getElementById('motorStatus').textContent = data.motor;
        })
        .catch(() => {});
}

// ─── Countdown motor ─────────────────────────────────────
const intervalMotor = 3 * 60 * 60; // 3 jam dalam detik
let sisa = intervalMotor;

setInterval(() => {
    const status = document.getElementById('motorStatus').textContent.trim();

    if (status === 'ON') {
        document.getElementById('motorInfo').textContent = 'Motor sedang berputar';
    } else {
        sisa = Math.max(0, sisa - 1);

        if (sisa <= 0) sisa = intervalMotor;

        const jam   = Math.floor(sisa / 3600);
        const menit = Math.floor((sisa % 3600) / 60);
        const detik = sisa % 60;

        document.getElementById('motorInfo').textContent =
            'Putar lagi: '
            + String(jam).padStart(2, '0') + ':'
            + String(menit).padStart(2, '0') + ':'
            + String(detik).padStart(2, '0');
    }
}, 1000);

// ─── Init ─────────────────────────────────────────────────
loadChart();
loadRealtime();

setInterval(loadChart, 10000);    // Update grafik tiap 10 detik
setInterval(loadRealtime, 3000);  // Update sensor tiap 3 detik
</script>

@endsection