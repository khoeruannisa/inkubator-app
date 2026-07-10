@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-dark">
        <i class="fa-solid fa-chart-line text-primary me-2"></i>Dashboard Inkubator
    </h4>
    <span class="badge bg-white text-dark shadow-sm py-2 px-3 border rounded-pill">
        <i class="fa-solid fa-circle text-success me-1 fa-pulse"></i> Monitoring Aktif
    </span>
</div>

<style>
    #chart {
        width: 100% !important;
        height: 380px !important;
    }

    .card-box {
        border-radius: 20px;
        padding: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .card-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .card-box::before {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        top: -20px;
        right: -20px;
        transition: all 0.3s ease;
    }

    .card-box:hover::before {
        transform: scale(1.3);
    }

    .card-box .icon-wrapper {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 16px;
    }

    /* Gradients */
    .bg-temp { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); }
    .bg-humi { background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); }
    .bg-egg-age { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .bg-active-heater { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .bg-inactive { background: linear-gradient(135deg, #64748b 0%, #475569 100%); }
    .bg-motor { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
    .bg-target-temp { background: linear-gradient(135deg, #334155 0%, #1e293b 100%); }
    .bg-target-humi { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
    .bg-mode { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }

    /* Custom badges */
    .badge-soft-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    .badge-soft-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }
    .badge-soft-primary {
        background-color: #dbeafe;
        color: #1e40af;
    }
</style>

{{-- ─── KARTU STATUS ─────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- SUHU --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-temp">
            <div class="icon-wrapper">
                <i class="fa-solid fa-temperature-three-quarters text-white"></i>
            </div>
            <small class="opacity-75 fw-semibold d-block">Suhu Saat Ini</small>
            <h3 class="mt-1 mb-0 fw-bold" id="suhu">{{ $data->suhu ?? 0 }} °C</h3>
        </div>
    </div>

    {{-- KELEMBAPAN --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-humi">
            <div class="icon-wrapper">
                <i class="fa-solid fa-droplet text-white"></i>
            </div>
            <small class="opacity-75 fw-semibold d-block">Kelembapan</small>
            <h3 class="mt-1 mb-0 fw-bold" id="kelembapan">{{ $data->kelembapan ?? 0 }} %</h3>
        </div>
    </div>

    {{-- USIA TELUR --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-egg-age">
            <div class="icon-wrapper">
                <i class="fa-solid fa-egg text-white"></i>
            </div>
            <small class="opacity-75 fw-semibold d-block">Usia Telur</small>
            <h3 class="mt-1 mb-0 fw-bold">{{ $usia }} Hari</h3>
        </div>
    </div>

    {{-- STATUS HEATER --}}
    <div class="col-md-3 col-6">
        <div id="heaterCard" class="card-box {{ ($kontrol->heater ?? 'OFF') == 'ON' ? 'bg-active-heater' : 'bg-inactive' }}">
            <div class="icon-wrapper">
                <i id="heaterIcon" class="fa-solid fa-fire text-white {{ ($kontrol->heater ?? 'OFF') == 'ON' ? 'fa-bounce' : '' }}"></i>
            </div>
            <small class="opacity-75 fw-semibold d-block">Heater</small>
            <h3 class="mt-1 mb-0 fw-bold" id="heater">{{ $kontrol->heater ?? 'OFF' }}</h3>
        </div>
    </div>

    {{-- MOTOR --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-motor">
            <div class="icon-wrapper">
                <i id="motorIcon" class="fa-solid fa-gear text-white {{ ($kontrol->motor ?? 'OFF') == 'ON' ? 'fa-spin' : '' }}"></i>
            </div>
            <small class="opacity-75 fw-semibold d-block">Motor Putar</small>
            <h3 class="mt-1 mb-0 fw-bold" id="motorStatus">{{ $kontrol->motor ?? 'OFF' }}</h3>
            <small id="motorInfo" class="opacity-75 d-block mt-1 small">Menunggu...</small>
        </div>
    </div>

    {{-- TARGET SUHU --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-target-temp">
            <div class="icon-wrapper">
                <i class="fa-solid fa-bullseye text-white"></i>
            </div>
            <small class="opacity-75 fw-semibold d-block">Target Suhu</small>
            <h3 class="mt-1 mb-0 fw-bold">{{ $kontrol->target_suhu ?? 37.5 }} °C</h3>
        </div>
    </div>

    {{-- TARGET KELEMBAPAN --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-target-humi">
            <div class="icon-wrapper">
                <i class="fa-solid fa-water text-white"></i>
            </div>
            <small class="opacity-75 fw-semibold d-block">Target Kelembapan</small>
            <h3 class="mt-1 mb-0 fw-bold">{{ $kontrol->target_kelembapan ?? 65 }} %</h3>
        </div>
    </div>

    {{-- MODE --}}
    <div class="col-md-3 col-6">
        <div class="card-box bg-mode">
            <div class="icon-wrapper">
                <i class="fa-solid fa-robot text-white"></i>
            </div>
            <small class="opacity-75 fw-semibold d-block">Mode</small>
            <h3 class="mt-1 mb-0 fw-bold" id="kontrolMode">{{ $kontrol->mode ?? 'Otomatis' }}</h3>
        </div>
    </div>

</div>

{{-- ─── GRAFIK ───────────────────────────────────────────── --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-chart-area text-danger me-2"></i>Grafik Suhu & Kelembapan (100 Data Terakhir)
                </h5>
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ─── TABEL DATA TERBARU ───────────────────────────────── --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold text-dark">
            <i class="fa-solid fa-table-list text-primary me-2"></i>10 Data Sensor Terbaru
        </h6>
        <span class="badge bg-light text-dark border">Realtime</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="py-3 px-4">No</th>
                    <th class="py-3">Suhu</th>
                    <th class="py-3">Kelembapan</th>
                    <th class="py-3">Heater</th>
                    <th class="py-3">Motor</th>
                    <th class="py-3 px-4">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($list as $item)
                <tr>
                    <td class="py-3 px-4 fw-medium text-secondary">{{ $loop->iteration }}</td>
                    <td class="py-3 fw-bold text-danger">
                        <i class="fa-solid fa-temperature-half me-1"></i>{{ $item->suhu }} °C
                    </td>
                    <td class="py-3 fw-bold text-primary">
                        <i class="fa-solid fa-droplet me-1"></i>{{ $item->kelembapan ?? '-' }} %
                    </td>
                    <td class="py-3">
                        <span class="badge {{ $item->heater == 'ON' ? 'badge-soft-success' : 'badge-soft-secondary' }} px-3 py-2 rounded-pill">
                            <i class="fa-solid {{ $item->heater == 'ON' ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>{{ $item->heater ?? '-' }}
                        </span>
                    </td>
                    <td class="py-3">
                        <span class="badge {{ ($item->motor ?? 'OFF') == 'ON' ? 'badge-soft-primary' : 'badge-soft-secondary' }} px-3 py-2 rounded-pill">
                            <i class="fa-solid {{ ($item->motor ?? 'OFF') == 'ON' ? 'fa-rotate' : 'fa-circle-xmark' }} me-1"></i>{{ $item->motor ?? '-' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-secondary">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fa-solid fa-circle-info fs-2 text-secondary mb-3 d-block"></i>
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
                            backgroundColor: 'rgba(239,68,68,0.05)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 2,
                            pointHoverRadius: 5,
                        },
                        {
                            label: 'Kelembapan (%)',
                            data: lembapData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59,130,246,0.05)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 2,
                            pointHoverRadius: 5,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { family: 'Plus Jakarta Sans' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Plus Jakarta Sans' } }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { font: { family: 'Plus Jakarta Sans', weight: '600' } }
                        }
                    },
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

            // Update Heater Card Background and Icon Animation dynamically
            const heaterCard = document.getElementById('heaterCard');
            const heaterIcon = document.getElementById('heaterIcon');
            if (data.heater === 'ON') {
                heaterCard.className = 'card-box bg-active-heater';
                heaterIcon.className = 'fa-solid fa-fire text-white fa-bounce';
            } else {
                heaterCard.className = 'card-box bg-inactive';
                heaterIcon.className = 'fa-solid fa-fire text-white';
            }
        })
        .catch(() => {}); // Jangan crash jika API lambat

    fetch('/api/kontrol')
        .then(res => res.json())
        .then(data => {
            document.getElementById('motorStatus').textContent = data.motor;
            document.getElementById('kontrolMode').textContent = data.mode;

            // Update Motor Icon Animation dynamically
            const motorIcon = document.getElementById('motorIcon');
            if (data.motor === 'ON') {
                motorIcon.className = 'fa-solid fa-gear text-white fa-spin';
            } else {
                motorIcon.className = 'fa-solid fa-gear text-white';
            }
        })
        .catch(() => {});
}

// ─── Countdown motor ─────────────────────────────────────
const intervalMotor = 3 * 60 * 60; // 3 jam dalam detik
let sisa = intervalMotor;

setInterval(() => {
    const status = document.getElementById('motorStatus').textContent.trim();

    if (status === 'ON') {
        document.getElementById('motorInfo').innerHTML = '<i class="fa-solid fa-arrows-spin fa-pulse me-1"></i>Motor sedang berputar';
    } else {
        sisa = Math.max(0, sisa - 1);

        if (sisa <= 0) sisa = intervalMotor;

        const jam   = Math.floor(sisa / 3600);
        const menit = Math.floor((sisa % 3600) / 60);
        const detik = sisa % 60;

        document.getElementById('motorInfo').innerHTML =
            '<i class="fa-solid fa-hourglass-half me-1"></i>Putar lagi: '
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