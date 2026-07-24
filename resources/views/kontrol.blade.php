@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1 text-dark">
            <i class="fa-solid fa-sliders text-primary me-2"></i>Kontrol Inkubator
        </h4>
        <p class="text-secondary mb-0 small">Kelola mode operasi dan perangkat inkubator</p>
    </div>
    <span class="badge rounded-pill py-2 px-3 fw-semibold"
          style="background:{{ $kontrol->mode=='Otomatis' ? '#ecfdf5' : '#fef3c7' }};color:{{ $kontrol->mode=='Otomatis' ? '#065f46' : '#92400e' }};font-size:12px;">
        <i class="fa-solid {{ $kontrol->mode=='Otomatis' ? 'fa-robot' : 'fa-hand' }} me-1"></i>
        Mode {{ $kontrol->mode }}
    </span>
</div>

@include('kontrol-styles')

{{-- MODE OPERASI --}}
<div class="ctrl-card mb-4">
    <div class="ctrl-card-header">
        <i class="fa-solid fa-toggle-on"></i> MODE OPERASI
    </div>
    <div class="p-3 p-md-4">
        <form action="/mode" method="POST">
            @csrf
            <label class="form-label fw-semibold">Pilih Mode Sistem</label>
            <select class="form-select mb-3 ctrl-select" name="mode">
                <option value="Otomatis" {{ $kontrol->mode=="Otomatis" ? "selected":"" }}>
                    🤖 Mode Otomatis
                </option>
                <option value="Manual" {{ $kontrol->mode=="Manual" ? "selected":"" }}>
                    🖐️ Mode Manual
                </option>
            </select>
            <button class="btn btn-primary w-100 ctrl-btn">
                <i class="fa-solid fa-save me-2"></i>Simpan Mode
            </button>
        </form>
    </div>
</div>

@if($kontrol->mode == 'Otomatis')
{{-- ═══ MODE OTOMATIS ═══ --}}
<div class="row g-3 mb-3">
    {{-- Target Parameter --}}
    <div class="col-md-6">
        <div class="ctrl-card h-100">
            <div class="ctrl-card-header"><i class="fa-solid fa-bullseye"></i> TARGET PARAMETER</div>
            <div class="p-3 p-md-4">
                <form action="/parameter" method="POST">
                    @csrf
                    <label class="form-label fw-semibold small">Target Suhu (°C)</label>
                    <input type="number" step="0.1" min="30" max="45" class="form-control mb-3 ctrl-input"
                           name="target_suhu" value="{{ $kontrol->target_suhu }}" required>
                    <label class="form-label fw-semibold small">Target Kelembapan (%)</label>
                    <input type="number" min="40" max="90" class="form-control mb-3 ctrl-input"
                           name="target_kelembapan" value="{{ $kontrol->target_kelembapan }}" required>
                    <button class="btn btn-success w-100 ctrl-btn">
                        <i class="fa-solid fa-check me-2"></i>Simpan Parameter
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Jadwal Putar Otomatis --}}
    <div class="col-md-6">
        <div class="ctrl-card h-100">
            <div class="ctrl-card-header"><i class="fa-solid fa-clock"></i> JADWAL PUTAR OTOMATIS</div>
            <div class="p-3 p-md-4">
                <form action="/jadwal-motor" method="POST">
                    @csrf
                    <label class="form-label fw-semibold small">Interval Putar (Jam)</label>
                    <input type="number" min="1" max="12" class="form-control mb-3 ctrl-input"
                           name="motor_interval_jam" value="{{ $kontrol->motor_interval_jam ?? 3 }}" required>
                    <label class="form-label fw-semibold small">Durasi Putar (Menit)</label>
                    <input type="number" min="1" max="60" class="form-control mb-3 ctrl-input"
                           name="motor_durasi_menit" value="{{ $kontrol->motor_durasi_menit ?? 5 }}" required>
                    <button class="btn btn-warning w-100 ctrl-btn text-dark">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Simpan Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Status & Timeline Otomatis --}}
<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="ctrl-card h-100">
            <div class="ctrl-card-header"><i class="fa-solid fa-list-check"></i> STATUS OTOMATIS</div>
            <div class="p-3 p-md-4">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-secondary">Mode</td><td><span class="badge bg-success">{{ $kontrol->mode }}</span></td></tr>
                    <tr><td class="text-secondary">Lampu</td><td class="fw-bold">{{ $kontrol->motor }}</td></tr>
                    <tr><td class="text-secondary">Motor Putar</td><td class="fw-bold">{{ $kontrol->kipas }}</td></tr>
                    <tr><td class="text-secondary">Interval Putar</td><td class="fw-bold">{{ $kontrol->motor_interval_jam ?? 3 }} Jam</td></tr>
                    <tr><td class="text-secondary">Durasi Putar</td><td class="fw-bold">{{ $kontrol->motor_durasi_menit ?? 5 }} Menit</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="ctrl-card h-100">
            <div class="ctrl-card-header"><i class="fa-solid fa-timeline"></i> JADWAL PUTAR HARI INI</div>
            <div class="p-3 p-md-4" id="autoTimelineContainer">
                <div class="text-center text-secondary py-3">
                    <i class="fa-solid fa-spinner fa-spin me-2"></i>Memuat jadwal...
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-success">
    <i class="fa-solid fa-robot me-2"></i>
    <div><b>Mode Otomatis aktif.</b> ESP8266 mengontrol Heater, Motor, dan Kipas secara otomatis berdasarkan parameter yang telah disimpan.</div>
</div>
@endif

@if($kontrol->mode == 'Manual')
{{-- ═══ MODE MANUAL ═══ --}}
<div class="row g-3 mb-3">

    {{-- LAMPU --}}
    <div class="col-sm-6 col-md-6">
        <div class="ctrl-card text-center p-3 p-md-4 h-100">
            <div class="device-icon bg-purple-soft"><i class="fa-solid fa-lightbulb text-warning"></i></div>
            <div class="device-label">LAMPU</div>
            <div class="device-status {{ $kontrol->motor=='ON' ? 'text-success':'text-secondary' }}">{{ $kontrol->motor }}</div>
            <form action="/motor" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $kontrol->motor=='ON' ? 'OFF':'ON' }}">
                <button class="btn {{ $kontrol->motor=='ON' ? 'btn-danger':'btn-success' }} w-100 ctrl-btn">
                    <i class="fa-solid {{ $kontrol->motor=='ON' ? 'fa-power-off':'fa-play' }} me-2"></i>
                    {{ $kontrol->motor=='ON' ? 'Matikan':'Hidupkan' }}
                </button>
            </form>
        </div>
    </div>


    {{-- MOTOR PUTAR --}}
    <div class="col-sm-6 col-md-6">
        <div class="ctrl-card text-center p-3 p-md-4 h-100">
            <div class="device-icon bg-info-soft"><i class="fa-solid fa-gear text-info"></i></div>
            <div class="device-label">MOTOR PUTAR</div>
            <div class="device-status {{ $kontrol->kipas=='ON' ? 'text-success':'text-secondary' }}">{{ $kontrol->kipas }}</div>
            <form action="/kipas" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $kontrol->kipas=='ON' ? 'OFF':'ON' }}">
                <button class="btn {{ $kontrol->kipas=='ON' ? 'btn-danger':'btn-success' }} w-100 ctrl-btn">
                    <i class="fa-solid {{ $kontrol->kipas=='ON' ? 'fa-power-off':'fa-play' }} me-2"></i>
                    {{ $kontrol->kipas=='ON' ? 'Matikan':'Hidupkan' }}
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Timeline Putar Motor (Manual) --}}
<div class="ctrl-card mb-3">
    <div class="ctrl-card-header"><i class="fa-solid fa-timeline"></i> TIMELINE PUTAR TELUR</div>
    <div class="p-3 p-md-4" id="manualTimelineContainer">
        <div class="text-center text-secondary py-3">
            <i class="fa-solid fa-spinner fa-spin me-2"></i>Memuat timeline...
        </div>
    </div>
</div>

<div class="alert alert-warning">
    <i class="fa-solid fa-hand me-2"></i>
    <div><b>Mode Manual Aktif.</b> Semua perangkat dikendalikan langsung melalui website. ESP8266 hanya menjalankan perintah dari website.</div>
</div>
@endif

{{-- Setting Saat Ini --}}
<div class="ctrl-card mt-3">
    <div class="ctrl-card-header bg-dark text-white" style="border-radius:18px 18px 0 0;">
        <i class="fa-solid fa-gear"></i> SETTING SAAT INI
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center mb-0 small">
            <thead class="table-light">
                <tr>
                    <th>Target Suhu</th><th>Target Lembap</th><th>Mode</th>
                    <th>Lampu</th><th>Motor Putar</th><th>Diubah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $kontrol->target_suhu }} °C</td>
                    <td>{{ $kontrol->target_kelembapan }} %</td>
                    <td>
                        <span class="badge {{ $kontrol->mode=='Otomatis' ? 'bg-success':'bg-warning text-dark' }}">
                            {{ $kontrol->mode }}
                        </span>
                    </td>
                    <td>{{ $kontrol->motor }}</td>
                    <td>{{ $kontrol->kipas }}</td>
                    <td>{{ $kontrol->updated_at ? \Carbon\Carbon::parse($kontrol->updated_at)->format('d-m-Y H:i') : '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($kontrol->mode == 'Otomatis')
    generateAutoTimeline();
    @endif

    @if($kontrol->mode == 'Manual')
    loadMotorTimeline();
    @endif
});

// ─── Mode Otomatis: Generate jadwal putar hari ini ─────────
function generateAutoTimeline() {
    const container = document.getElementById('autoTimelineContainer');
    const interval  = {{ $kontrol->motor_interval_jam ?? 3 }};
    const durasi    = {{ $kontrol->motor_durasi_menit ?? 5 }};

    let html = '<div class="timeline-list">';
    const now  = new Date();
    const nowH = now.getHours();
    const nowM = now.getMinutes();
    let slot   = 0;

    for (let h = 0; h < 24; h += interval) {
        slot++;
        // Hitung waktu akhir dengan benar (overflow menit ke jam)
        const endTotalMenit = h * 60 + durasi;
        const endH  = Math.floor(endTotalMenit / 60) % 24;
        const start = String(h).padStart(2,'0') + ':00';
        const end   = String(endH).padStart(2,'0') + ':' + String(endTotalMenit % 60).padStart(2,'0');

        // isNow: jam slot = nowH DAN nowM masih dalam durasi
        const isNow  = (nowH === h) && (nowM < durasi);
        // isPast: jam slot sudah lewat, atau jam sama tapi sudah melewati durasi
        const isPast = (nowH > h) || (nowH === h && nowM >= durasi);

        const statusClass = isNow ? 'tl-active' : (isPast ? 'tl-done' : 'tl-pending');
        const icon  = isNow ? 'fa-arrows-spin fa-spin text-primary' : (isPast ? 'fa-circle-check text-success' : 'fa-clock text-secondary');
        const label = isNow ? 'Sedang berjalan' : (isPast ? 'Selesai' : 'Terjadwal');
        const bg    = isNow ? '#dbeafe;color:#1e40af' : (isPast ? '#d1fae5;color:#065f46' : '#f1f5f9;color:#64748b');

        html += '<div class="tl-item ' + statusClass + '">';
        html += '<div class="tl-dot"><i class="fa-solid ' + icon + '"></i></div>';
        html += '<div class="tl-content">';
        html += '<div class="fw-bold small">Putaran #' + slot + '</div>';
        html += '<div class="text-secondary" style="font-size:12px"><i class="fa-regular fa-clock me-1"></i>' + start + ' &ndash; ' + end + ' (' + durasi + ' menit)</div>';
        html += '<span class="badge rounded-pill mt-1" style="font-size:10px;background:' + bg + '">' + label + '</span>';
        html += '</div></div>';
    }
    html += '</div>';
    container.innerHTML = html;
}

// ─── Mode Manual: Load timeline putar dari server ──────────
function loadMotorTimeline() {
    const container = document.getElementById('manualTimelineContainer');

    fetch('/kontrol/motor-timeline')
        .then(r => r.json())
        .then(data => {
            const tl = data.timeline || [];
            if (tl.length === 0) {
                container.innerHTML = '<div class="text-center text-secondary py-4">'
                    + '<i class="fa-solid fa-inbox fa-2x mb-2 d-block" style="opacity:.4"></i>'
                    + '<p class="mb-0 fw-semibold">Belum ada riwayat putar motor</p>'
                    + '<p class="small mb-0">Hidupkan motor untuk mulai mencatat</p></div>';
                return;
            }

            let html = '<div class="timeline-list">';
            tl.forEach((item, i) => {
                const onDate  = new Date(item.on);
                const onStr   = onDate.toLocaleString('id-ID', {day:'2-digit',month:'short',hour:'2-digit',minute:'2-digit'});
                const offStr  = item.off ? new Date(item.off).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}) : 'Masih ON';
                const running = !item.off;

                html += '<div class="tl-item ' + (running ? 'tl-active' : 'tl-done') + '">';
                html += '<div class="tl-dot"><i class="fa-solid ' + (running ? 'fa-gear fa-spin text-primary' : 'fa-circle-check text-success') + '"></i></div>';
                html += '<div class="tl-content">';
                html += '<div class="fw-bold small">Sesi #' + (tl.length - i) + '</div>';
                html += '<div class="text-secondary" style="font-size:12px">';
                html += '<i class="fa-solid fa-play text-success me-1"></i>ON: ' + onStr;
                html += ' &nbsp;→&nbsp; <i class="fa-solid fa-stop text-danger me-1"></i>OFF: ' + offStr;
                html += '</div>';
                html += '<span class="badge rounded-pill mt-1" style="font-size:10px;background:' + (running ? '#dbeafe;color:#1e40af' : '#f1f5f9;color:#64748b') + '">';
                html += '<i class="fa-solid fa-hourglass-half me-1"></i>Durasi: ' + item.durasi;
                html += '</span>';
                html += '</div></div>';
            });
            html += '</div>';
            container.innerHTML = html;
        })
        .catch(() => {
            container.innerHTML = '<div class="text-center text-danger py-3"><i class="fa-solid fa-exclamation-triangle me-2"></i>Gagal memuat timeline</div>';
        });
}
</script>

@endsection