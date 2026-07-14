@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark">
            <i class="fa-solid fa-sliders text-primary me-2"></i>Kontrol Parameter
        </h4>
        <p class="text-secondary mb-0 small">Atur parameter inkubator dalam mode otomatis</p>
    </div>
    <span class="badge rounded-pill fw-semibold py-2 px-3" style="background:#ede9fe;color:#5b21b6;font-size:12px;">
        <i class="fa-solid fa-robot me-1"></i>Mode Otomatis Aktif
    </span>
</div>

<style>
    .param-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .param-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .param-card-header {
        padding: 20px 24px 0;
    }

    .param-card-body {
        padding: 20px 24px 24px;
    }

    .section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.3px;
    }

    .section-desc {
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .param-divider {
        height: 1px;
        background: linear-gradient(to right, #e2e8f0, transparent);
        margin: 18px 0;
    }

    .form-label-custom {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-control-custom {
        border-radius: 14px;
        padding: 13px 18px;
        border: 2px solid #e2e8f0;
        font-weight: 600;
        color: #0f172a;
        font-size: 16px;
        transition: all 0.2s ease;
        background-color: #f8fafc;
        width: 100%;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: #6366f1;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
    }

    .btn-save {
        border: none;
        border-radius: 14px;
        padding: 14px 24px;
        font-weight: 700;
        font-size: 14px;
        color: white;
        transition: all 0.25s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
    }

    .btn-save-indigo {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        box-shadow: 0 6px 20px rgba(79,70,229,0.25);
    }

    .btn-save-indigo:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(79,70,229,0.35);
        background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
    }

    .btn-save-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 6px 20px rgba(16,185,129,0.25);
    }

    .btn-save-green:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(16,185,129,0.35);
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    /* Info banner */
    .auto-info-banner {
        background: linear-gradient(135deg, #ede9fe 0%, #e0e7ff 100%);
        border-radius: 16px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
        border-left: 4px solid #6366f1;
    }

    .auto-info-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        flex-shrink: 0;
    }

    /* Status summary card */
    .status-summary {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 20px;
        padding: 24px;
        color: white;
        box-shadow: 0 8px 30px rgba(15,23,42,0.3);
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }

    .status-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .status-item-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .status-item-value {
        font-weight: 700;
        font-size: 15px;
    }

    .badge-pill-green  { background: rgba(16,185,129,0.2); color: #34d399; padding: 4px 12px; border-radius: 20px; font-size: 12px; }
    .badge-pill-yellow { background: rgba(245,158,11,0.2); color: #fbbf24; padding: 4px 12px; border-radius: 20px; font-size: 12px; }
    .badge-pill-blue   { background: rgba(99,102,241,0.2); color: #a5b4fc; padding: 4px 12px; border-radius: 20px; font-size: 12px; }

    /* Range slider style */
    .range-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 8px;
    }

    .range-display {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        min-width: 80px;
        text-align: center;
    }
</style>

{{-- ─── INFO BANNER OTOMATIS ─────────────────────────────── --}}
<div class="auto-info-banner">
    <div class="auto-info-icon">
        <i class="fa-solid fa-robot"></i>
    </div>
    <div>
        <div style="font-weight:700;color:#3730a3;margin-bottom:3px;">Sistem Berjalan Otomatis</div>
        <div style="font-size:13px;color:#5b21b6;line-height:1.5;">
            Inkubator akan mengatur heater, kipas, dan motor putar secara otomatis berdasarkan set point di bawah.
        </div>
    </div>
</div>

{{-- ─── BARIS UTAMA: PARAMETER + STATUS ──────────────────── --}}
<div class="row g-4">

    {{-- KOLOM KIRI: Form Parameter --}}
    <div class="col-lg-8">

        {{-- TARGET SUHU & KELEMBAPAN --}}
        <div class="param-card mb-4">
            <div class="param-card-header">
                <div class="section-label">
                    <i class="fa-solid fa-bullseye text-success"></i>Set Point Parameter
                </div>
                <div class="section-title">Target Suhu & Kelembapan</div>
                <p class="section-desc">Atur ambang batas suhu dan kelembapan. Heater akan menyala secara otomatis jika di bawah target.</p>
            </div>
            <div class="param-divider"></div>
            <div class="param-card-body pt-0">
                <form action="/parameter" method="POST">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="fa-solid fa-temperature-half text-danger"></i>Suhu Target (°C)
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                name="target_suhu"
                                class="form-control-custom"
                                value="{{ $kontrol->target_suhu }}"
                                min="30" max="45"
                                required>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-secondary" style="font-size:11px;">Min: 30°C</small>
                                <small class="text-secondary" style="font-size:11px;">Rekomendasi: 37-38°C</small>
                                <small class="text-secondary" style="font-size:11px;">Max: 45°C</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="fa-solid fa-droplet text-primary"></i>Kelembapan Target (%)
                            </label>
                            <input
                                type="number"
                                name="target_kelembapan"
                                class="form-control-custom"
                                value="{{ $kontrol->target_kelembapan }}"
                                min="40" max="90"
                                required>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-secondary" style="font-size:11px;">Min: 40%</small>
                                <small class="text-secondary" style="font-size:11px;">Rekomendasi: 60-70%</small>
                                <small class="text-secondary" style="font-size:11px;">Max: 90%</small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-save btn-save-green">
                        <i class="fa-solid fa-circle-check"></i>Simpan Parameter
                    </button>
                </form>
            </div>
        </div>

        {{-- INFO CARA KERJA --}}
        <div class="param-card">
            <div class="param-card-header">
                <div class="section-label">
                    <i class="fa-solid fa-info-circle text-info"></i>Cara Kerja Otomatis
                </div>
                <div class="section-title">Logika Kontrol Sistem</div>
            </div>
            <div class="param-divider"></div>
            <div class="param-card-body pt-0">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div style="background:#fef2f2;border-radius:14px;padding:16px;">
                            <div style="width:36px;height:36px;background:#fca5a5;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                                <i class="fa-solid fa-fire text-danger"></i>
                            </div>
                            <div style="font-weight:700;color:#7f1d1d;font-size:13px;margin-bottom:4px;">Heater Otomatis</div>
                            <div style="font-size:12px;color:#991b1b;line-height:1.5;">Menyala jika suhu < target. Mati jika suhu ≥ target.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:#eff6ff;border-radius:14px;padding:16px;">
                            <div style="width:36px;height:36px;background:#93c5fd;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                                <i class="fa-solid fa-wind text-primary"></i>
                            </div>
                            <div style="font-weight:700;color:#1e3a5f;font-size:13px;margin-bottom:4px;">Kipas Otomatis</div>
                            <div style="font-size:12px;color:#1d4ed8;line-height:1.5;">Berputar jika kelembapan < target untuk sirkulasi udara.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:#faf5ff;border-radius:14px;padding:16px;">
                            <div style="width:36px;height:36px;background:#c4b5fd;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                                <i class="fa-solid fa-gear" style="color:#6d28d9;"></i>
                            </div>
                            <div style="font-weight:700;color:#3b0764;font-size:13px;margin-bottom:4px;">Motor Terjadwal</div>
                            <div style="font-size:12px;color:#6d28d9;line-height:1.5;">Berputar setiap 3 jam sekali untuk pembalikan telur.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- KOLOM KANAN: Status Saat Ini --}}
    <div class="col-lg-4">
        <div class="status-summary">
            <div style="font-size:13px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">
                <i class="fa-solid fa-signal me-2"></i>Status Konfigurasi
            </div>

            <div class="status-item">
                <span class="status-item-label">Target Suhu</span>
                <span class="status-item-value text-danger">{{ $kontrol->target_suhu }} °C</span>
            </div>

            <div class="status-item">
                <span class="status-item-label">Target Kelembapan</span>
                <span class="status-item-value text-info">{{ $kontrol->target_kelembapan }} %</span>
            </div>

            <div class="status-item">
                <span class="status-item-label">Mode Operasi</span>
                <span class="badge-pill-blue">
                    <i class="fa-solid fa-robot me-1"></i>{{ $kontrol->mode ?? 'Otomatis' }}
                </span>
            </div>

            <div class="status-item">
                <span class="status-item-label">Status Heater</span>
                @if(($kontrol->heater ?? 'OFF') == 'ON')
                    <span class="badge-pill-green"><i class="fa-solid fa-fire me-1"></i>ON</span>
                @else
                    <span style="background:rgba(100,116,139,0.2);color:#94a3b8;padding:4px 12px;border-radius:20px;font-size:12px;">OFF</span>
                @endif
            </div>

            <div class="status-item">
                <span class="status-item-label">Status Motor</span>
                @if(($kontrol->motor ?? 'OFF') == 'ON')
                    <span class="badge-pill-yellow"><i class="fa-solid fa-gear fa-spin me-1"></i>ON</span>
                @else
                    <span style="background:rgba(100,116,139,0.2);color:#94a3b8;padding:4px 12px;border-radius:20px;font-size:12px;">OFF</span>
                @endif
            </div>

            <div class="status-item">
                <span class="status-item-label">Status Kipas</span>
                @if(($kontrol->kipas ?? 'OFF') == 'ON')
                    <span class="badge-pill-blue"><i class="fa-solid fa-fan fa-spin me-1"></i>ON</span>
                @else
                    <span style="background:rgba(100,116,139,0.2);color:#94a3b8;padding:4px 12px;border-radius:20px;font-size:12px;">OFF</span>
                @endif
            </div>

            <div class="status-item">
                <span class="status-item-label">Terakhir Diubah</span>
                <span class="status-item-value" style="font-size:12px;color:#64748b;">
                    {{ $kontrol->updated_at ? \Carbon\Carbon::parse($kontrol->updated_at)->format('d/m H:i') : '-' }}
                </span>
            </div>
        </div>

        {{-- Quick Info --}}
        <div style="margin-top: 16px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 16px; padding: 16px 18px; border-left: 4px solid #f59e0b;">
            <div style="font-weight:700;color:#92400e;font-size:13px;margin-bottom:6px;">
                <i class="fa-solid fa-lightbulb me-1"></i>Tips Penetasan
            </div>
            <div style="font-size:12px;color:#78350f;line-height:1.6;">
                Suhu ideal <strong>37.5–38°C</strong> dan kelembapan <strong>60–65%</strong> untuk hasil penetasan terbaik.
            </div>
        </div>
    </div>

</div>

@endsection