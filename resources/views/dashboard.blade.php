@extends('layout')

@section('content')

@php
    // Null safety: jika sensors kosong, $data bisa null
    $data = $data ?? (object)['suhu' => 0, 'kelembapan' => 0, 'heater' => 'OFF', 'motor' => 'OFF'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1 text-dark">
            <i class="fa-solid fa-chart-line text-primary me-2"></i>Dashboard Inkubator
        </h4>
        <p class="text-secondary mb-0 small">Monitoring real-time inkubator telur otomatis</p>
    </div>
    <span class="badge bg-white text-dark shadow-sm py-2 px-3 border rounded-pill">
        <i class="fa-solid fa-circle text-success me-1 fa-pulse"></i> Monitoring Aktif
    </span>
</div>

<style>
    #chart {
        width: 100% !important;
        height: 350px !important;
    }

    .stat-card {
        border-radius: 20px;
        padding: 20px 18px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        cursor: default;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.18);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -30px;
        right: -30px;
        transition: all 0.35s ease;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
        bottom: -10px;
        right: 50px;
    }

    .stat-card:hover::before { transform: scale(1.4); }

    .stat-card .icon-wrapper {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 12px;
        backdrop-filter: blur(4px);
        flex-shrink: 0;
    }

    .stat-card .stat-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        opacity: 0.8;
        margin-bottom: 2px;
    }

    .stat-card .stat-value {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .stat-card .stat-sub {
        font-size: 10px;
        opacity: 0.7;
        margin-top: 4px;
    }

    /* Gradients */
    .bg-temp        { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); }
    .bg-humi        { background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); }
    .bg-heater-on   { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .bg-heater-off  { background: linear-gradient(135deg, #64748b 0%, #475569 100%); }
    .bg-motor       { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
    .bg-target-temp { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); }
    .bg-target-humi { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
    .bg-mode        { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
    .bg-kipas       { background: linear-gradient(135deg, #06b6d4 0%, #0e7490 100%); }

    /* Badges */
    .badge-soft-success  { background: #d1fae5; color: #065f46; }
    .badge-soft-danger   { background: #fee2e2; color: #991b1b; }
    .badge-soft-primary  { background: #dbeafe; color: #1e40af; }
    .badge-soft-secondary { background: #f1f5f9; color: #475569; }

    /* Chart Card */
    .chart-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border: none;
        overflow: hidden;
    }

    .chart-header {
        padding: 20px 24px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .chart-body { padding: 16px 24px 24px; }

    .data-table-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .data-table-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 18px 24px;
    }

    .table > :not(caption) > * > * { padding: 12px 16px; }

    .table thead th {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .table tbody tr {
        border-color: #f1f5f9;
        transition: background 0.15s ease;
    }

    .table tbody tr:hover { background: #f8fafc; }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        display: block;
        opacity: 0.5;
    }

    .chart-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 350px;
        color: #94a3b8;
        flex-direction: column;
        gap: 12px;
    }

    /* Responsif: di layar kecil tabel bisa scroll */
    @media (max-width: 575.98px) {
        .stat-card .stat-value { font-size: 18px; }
        .stat-card { padding: 16px 14px; }
        .chart-header { padding: 14px 16px 0; }
        .chart-body { padding: 12px 16px 16px; }
        .data-table-card .card-header { padding: 14px 16px; }
    }
</style>

{{-- ─── KARTU STATUS ─────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- SUHU --}}
    <div class="col-6 col-md-3">
        <div class="stat-card bg-temp">
            <div class="icon-wrapper"><i class="fa-solid fa-temperature-three-quarters"></i></div>
            <div class="stat-label">Suhu Saat Ini</div>
            <div class="stat-value" id="suhu">{{ $data->suhu ?? 0 }} °C</div>
            <div class="stat-sub"><i class="fa-solid fa-circle-dot me-1"></i>Live</div>
        </div>
    </div>

    {{-- KELEMBAPAN --}}
    <div class="col-6 col-md-3">
        <div class="stat-card bg-humi">
            <div class="icon-wrapper"><i class="fa-solid fa-droplet"></i></div>
            <div class="stat-label">Kelembapan</div>
            <div class="stat-value" id="kelembapan">{{ $data->kelembapan ?? 0 }} %</div>
            <div class="stat-sub"><i class="fa-solid fa-circle-dot me-1"></i>Live</div>
        </div>
    </div>

    {{-- STATUS HEATER --}}
    <div class="col-6 col-md-3">
        <div id="heaterCard" class="stat-card {{ ($kontrol->heater ?? 'OFF') == 'ON' ? 'bg-heater-on' : 'bg-heater-off' }}">
            <div class="icon-wrapper">
                <i id="heaterIcon" class="fa-solid fa-fire {{ ($kontrol->heater ?? 'OFF') == 'ON' ? 'fa-bounce' : '' }}"></i>
            </div>
            <div class="stat-label">Heater</div>
            <div class="stat-value" id="heater">{{ $kontrol->heater ?? 'OFF' }}</div>
            <div class="stat-sub">Pemanas Otomatis</div>
        </div>
    </div>

    {{-- MOTOR --}}
    <div class="col-6 col-md-3">
        <div class="stat-card bg-motor">
            <div class="icon-wrapper">
                <i id="motorIcon" class="fa-solid fa-gear {{ ($kontrol->motor ?? 'OFF') == 'ON' ? 'fa-spin' : '' }}"></i>
            </div>
            <div class="stat-label">Motor Putar</div>
            <div class="stat-value" id="motorStatus">{{ $kontrol->motor ?? 'OFF' }}</div>
            <div class="stat-sub" id="motorInfo">Memuat info...</div>
        </div>
    </div>

    {{-- TARGET SUHU --}}
    <div class="col-6 col-md-3">
        <div class="stat-card bg-target-temp">
            <div class="icon-wrapper"><i class="fa-solid fa-bullseye"></i></div>
            <div class="stat-label">Target Suhu</div>
            <div class="stat-value">{{ $kontrol->target_suhu ?? 37.5 }} °C</div>
            <div class="stat-sub">Set Point</div>
        </div>
    </div>

    {{-- TARGET KELEMBAPAN --}}
    <div class="col-6 col-md-3">
        <div class="stat-card bg-target-humi">
            <div class="icon-wrapper"><i class="fa-solid fa-water"></i></div>
            <div class="stat-label">Target Lembap</div>
            <div class="stat-value">{{ $kontrol->target_kelembapan ?? 65 }} %</div>
            <div class="stat-sub">Set Point</div>
        </div>
    </div>

    {{-- MODE --}}
    <div class="col-6 col-md-3">
        <div class="stat-card bg-mode">
            <div class="icon-wrapper"><i class="fa-solid fa-robot"></i></div>
            <div class="stat-label">Mode Operasi</div>
            <div class="stat-value" id="kontrolMode" style="font-size:18px;">{{ $kontrol->mode ?? 'Otomatis' }}</div>
            <div class="stat-sub">Sistem Mandiri</div>
        </div>
    </div>

    {{-- KIPAS --}}
    <div class="col-6 col-md-3">
        <div class="stat-card bg-kipas">
            <div class="icon-wrapper">
                <i id="kipasIcon" class="fa-solid fa-fan {{ ($kontrol->kipas ?? 'OFF') == 'ON' ? 'fa-spin' : '' }}"></i>
            </div>
            <div class="stat-label">Kipas</div>
            <div class="stat-value" id="kipasStatus">{{ $kontrol->kipas ?? 'OFF' }}</div>
            <div class="stat-sub">Sirkulasi Udara</div>
        </div>
    </div>

</div>

{{-- ─── GRAFIK ───────────────────────────────────────────── --}}
<div class="chart-card mb-4">
    <div class="chart-header">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-chart-area text-danger me-2"></i>Grafik Suhu &amp; Kelembapan
        </h5>
        <span class="badge rounded-pill" style="background:#fef2f2;color:#dc2626;font-size:11px;padding:6px 14px;">
            <i class="fa-solid fa-rotate me-1"></i>Update tiap 10 detik
        </span>
    </div>
    <div class="chart-body">
        <div id="chartWrapper">
            <div class="chart-loading" id="chartLoading">
                <i class="fa-solid fa-spinner fa-spin fa-2x text-primary"></i>
                <span class="small text-secondary">Memuat data grafik...</span>
            </div>
            <canvas id="chart" style="display:none;"></canvas>
        </div>
    </div>
</div>

{{-- ─── TABEL DATA TERBARU ───────────────────────────────── --}}
<div class="data-table-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold text-dark">
            <i class="fa-solid fa-table-list text-primary me-2"></i>10 Data Sensor Terbaru
        </h6>
        <span class="badge rounded-pill" style="background:#dbeafe;color:#1e40af;font-size:11px;padding:6px 14px;">
            <i class="fa-solid fa-circle text-success me-1" style="font-size:8px;"></i>Realtime
        </span>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th class="px-4">No</th>
                    <th>Suhu</th>
                    <th>Kelembapan</th>
                    <th>Heater</th>
                    <th>Motor</th>
                    <th class="px-4">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($list as $item)
                <tr>
                    <td class="px-4 fw-semibold text-secondary">{{ $loop->iteration }}</td>
                    <td>
                        <span class="fw-bold text-danger">
                            <i class="fa-solid fa-temperature-half me-1"></i>{{ $item->suhu }} °C
                        </span>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">
                            <i class="fa-solid fa-droplet me-1"></i>{{ $item->kelembapan ?? '-' }} %
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $item->heater == 'ON' ? 'badge-soft-success' : 'badge-soft-secondary' }} px-3 py-2 rounded-pill" style="font-size:12px;">
                            <i class="fa-solid {{ $item->heater == 'ON' ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>{{ $item->heater ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ ($item->motor ?? 'OFF') == 'ON' ? 'badge-soft-primary' : 'badge-soft-secondary' }} px-3 py-2 rounded-pill" style="font-size:12px;">
                            <i class="fa-solid {{ ($item->motor ?? 'OFF') == 'ON' ? 'fa-rotate' : 'fa-circle-xmark' }} me-1"></i>{{ $item->motor ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 text-secondary small">
                        <i class="fa-regular fa-clock me-1"></i>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m H:i:s') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fa-solid fa-satellite-dish"></i>
                            <p class="mb-0 fw-semibold">Belum ada data sensor</p>
                            <p class="small mb-0">Menunggu data dari perangkat...</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ─── SCRIPTS ──────────────────────────────────────────── --}}
<script>
let chart = null;

function loadChart() {
    fetch('/api/suhu')
        .then(res => {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(data => {
            const canvas  = document.getElementById('chart');
            const loading = document.getElementById('chartLoading');

            if (!data || data.length === 0) {
                loading.innerHTML = '<i class="fa-solid fa-chart-area fa-2x" style="opacity:0.3"></i><span class="small text-secondary">Belum ada data grafik tersedia</span>';
                return;
            }

            loading.style.display = 'none';
            canvas.style.display  = 'block';

            const labels     = [];
            const suhuData   = [];
            const lembapData = [];

            data.forEach(item => {
                const waktu = new Date(item.created_at);
                labels.push(waktu.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }));
                suhuData.push(parseFloat(item.suhu) || 0);
                lembapData.push(parseFloat(item.kelembapan) || 0);
            });

            if (chart) {
                chart.data.labels = labels;
                chart.data.datasets[0].data = suhuData;
                chart.data.datasets[1].data = lembapData;
                chart.update('none');
                return;
            }

            chart = new Chart(canvas, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Suhu (°C)',
                            data: suhuData,
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239,68,68,0.08)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#ef4444',
                        },
                        {
                            label: 'Kelembapan (%)',
                            data: lembapData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59,130,246,0.08)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#3b82f6',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 400 },
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        y: {
                            grid: { color: '#f1f5f9', lineWidth: 1 },
                            border: { dash: [4, 4] },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 11 },
                                color: '#94a3b8',
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 11 },
                                color: '#94a3b8',
                                maxTicksLimit: 10,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                font: { family: 'Plus Jakarta Sans', weight: '600', size: 12 },
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: 'Plus Jakarta Sans', weight: '700' },
                            bodyFont:  { family: 'Plus Jakarta Sans' },
                            padding: 12,
                            cornerRadius: 10,
                        }
                    },
                },
            });
        })
        .catch(err => {
            console.error('Chart error:', err);
            const loading = document.getElementById('chartLoading');
            loading.innerHTML = '<i class="fa-solid fa-triangle-exclamation fa-2x text-warning"></i><span class="small text-secondary">Gagal memuat data grafik</span>';
        });
}

// ─── Realtime sensor update ───────────────────────────────
function loadRealtime() {
    // Update sensor (suhu, kelembapan, heater)
    fetch('/api/sensor')
        .then(res => res.json())
        .then(data => {
            document.getElementById('suhu').textContent       = data.suhu + ' °C';
            document.getElementById('kelembapan').textContent = data.kelembapan + ' %';
            document.getElementById('heater').textContent     = data.heater;

            const heaterCard = document.getElementById('heaterCard');
            const heaterIcon = document.getElementById('heaterIcon');
            if (data.heater === 'ON') {
                heaterCard.className = 'stat-card bg-heater-on';
                heaterIcon.className = 'fa-solid fa-fire fa-bounce';
            } else {
                heaterCard.className = 'stat-card bg-heater-off';
                heaterIcon.className = 'fa-solid fa-fire';
            }
        })
        .catch(() => {});

    // Update kontrol (motor, kipas, mode) + countdown sinkron server
    fetch('/api/kontrol')
        .then(res => res.json())
        .then(data => {
            const motorStatus = data.motor  || 'OFF';
            const kipasStatus = data.kipas  || 'OFF';

            document.getElementById('motorStatus').textContent = motorStatus;
            document.getElementById('kontrolMode').textContent = data.mode || '-';

            // Motor icon
            const motorIcon = document.getElementById('motorIcon');
            if (motorStatus === 'ON') {
                motorIcon.className = 'fa-solid fa-gear fa-spin';
                document.getElementById('motorInfo').innerHTML =
                    '<i class="fa-solid fa-arrows-spin fa-pulse me-1"></i>Motor sedang berputar';
                // Hentikan countdown jika motor ON
                if (countdownTimer) {
                    clearInterval(countdownTimer);
                    countdownTimer = null;
                }
            } else {
                motorIcon.className = 'fa-solid fa-gear';
                // Hitung countdown berdasarkan motor_last_on dari server
                updateCountdown(data.motor_last_on, data.motor_interval_jam || 3);
            }

            // Kipas icon
            const kipasEl   = document.getElementById('kipasStatus');
            const kipasIcon = document.getElementById('kipasIcon');
            if (kipasEl)   kipasEl.textContent = kipasStatus;
            if (kipasIcon) {
                kipasIcon.className = kipasStatus === 'ON'
                    ? 'fa-solid fa-fan fa-spin'
                    : 'fa-solid fa-fan';
            }
        })
        .catch(() => {});
}

// ─── Countdown motor sinkron dengan data server ───────────
// Dihitung dari motor_last_on yang disimpan di DB
let countdownTimer = null;

function updateCountdown(motorLastOn, intervalJam) {
    if (countdownTimer) clearInterval(countdownTimer);

    if (!motorLastOn) {
        document.getElementById('motorInfo').innerHTML =
            '<i class="fa-solid fa-hourglass-start me-1"></i>Belum ada data putar';
        return;
    }

    const intervalDetik = intervalJam * 3600;
    const lastOn        = new Date(motorLastOn).getTime();

    function tick() {
        const now        = Date.now();
        const elapsed    = Math.floor((now - lastOn) / 1000);
        const sisaDetik  = Math.max(0, intervalDetik - elapsed);

        if (sisaDetik <= 0) {
            document.getElementById('motorInfo').innerHTML =
                '<i class="fa-solid fa-rotate me-1 text-warning"></i>Jadwal putar segera!';
            return;
        }

        const jam   = Math.floor(sisaDetik / 3600);
        const menit = Math.floor((sisaDetik % 3600) / 60);
        const detik = sisaDetik % 60;

        document.getElementById('motorInfo').innerHTML =
            '<i class="fa-solid fa-hourglass-half me-1"></i>Putar lagi: '
            + String(jam).padStart(2, '0') + ':'
            + String(menit).padStart(2, '0') + ':'
            + String(detik).padStart(2, '0');
    }

    tick();
    countdownTimer = setInterval(tick, 1000);
}

// ─── Init ─────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    loadChart();
    loadRealtime();
    setInterval(loadChart,     10000);
    setInterval(loadRealtime,   3000);
});
</script>

@endsection