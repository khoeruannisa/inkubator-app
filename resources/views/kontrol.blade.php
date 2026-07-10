@extends('layout')

@section('content')

<h4 class="mb-4 fw-bold text-dark">
    <i class="fa-solid fa-sliders text-primary me-2"></i>Kontrol Perangkat & Parameter
</h4>

<style>
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -6px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge {
        font-size: 26px;
        font-weight: 800;
        text-align: center;
        margin: 16px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .on  { 
        color: #10b981;
        text-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
    }
    .off { 
        color: #94a3b8; 
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        font-weight: 500;
        color: #334155;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }

    .btn-submit {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        color: white;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.25);
        background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
    }

    .toggle-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .icon-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px auto;
        font-size: 24px;
        transition: all 0.3s ease;
    }

    .icon-circle.active-heater { background-color: #fef2f2; color: #ef4444; }
    .icon-circle.inactive-heater { background-color: #f1f5f9; color: #94a3b8; }

    .icon-circle.active-motor { background-color: #faf5ff; color: #a855f7; }
    .icon-circle.inactive-motor { background-color: #f1f5f9; color: #94a3b8; }

    .icon-circle.active-kipas { background-color: #ecfeff; color: #06b6d4; }
    .icon-circle.inactive-kipas { background-color: #f1f5f9; color: #94a3b8; }

    /* soft badges */
    .badge-soft-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    .badge-soft-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
</style>

{{-- ─── BARIS 1: Mode & Target ───────────────────────────── --}}
<div class="row g-4 mb-4">

    {{-- MODE OPERASI --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="section-title">
                <i class="fa-solid fa-gears text-primary"></i>Mode Operasi
            </div>
            <p class="text-secondary small mb-4">Pilih mode operasi inkubator. Mode Otomatis akan menyesuaikan suhu & kelembapan berdasarkan sensor.</p>

            <form action="/mode" method="POST">
                @csrf
                <div class="mb-4">
                    <select class="form-select" name="mode">
                        <option value="Otomatis" {{ $kontrol->mode == 'Otomatis' ? 'selected' : '' }}>
                            🤖 Otomatis (Sistem Mandiri)
                        </option>
                        <option value="Manual" {{ $kontrol->mode == 'Manual' ? 'selected' : '' }}>
                            🖐️ Manual (Kontrol Penuh)
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-submit w-100 py-3">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Mode
                </button>
            </form>
        </div>
    </div>

    {{-- TARGET PARAMETER --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="section-title">
                <i class="fa-solid fa-bullseye text-success"></i>Target Parameter
            </div>
            <p class="text-secondary small mb-3">Atur ambang batas suhu dan kelembapan inkubator untuk menjaga telur tetap stabil.</p>

            <form action="/parameter" method="POST">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-secondary small mb-2">
                            <i class="fa-solid fa-temperature-half text-danger me-1"></i>Suhu Target (°C)
                        </label>
                        <input
                            type="number"
                            step="0.1"
                            name="target_suhu"
                            class="form-control"
                            value="{{ $kontrol->target_suhu }}"
                            min="30" max="45"
                            required>
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold text-secondary small mb-2">
                            <i class="fa-solid fa-droplet text-primary me-1"></i>Kelembapan Target (%)
                        </label>
                        <input
                            type="number"
                            name="target_kelembapan"
                            class="form-control"
                            value="{{ $kontrol->target_kelembapan }}"
                            min="40" max="90"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-submit w-100 py-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);">
                    <i class="fa-solid fa-circle-check me-2"></i>Simpan Parameter
                </button>
            </form>
        </div>
    </div>

</div>

{{-- ─── BARIS 2: Toggle Perangkat ───────────────────────── --}}
<div class="row g-4 mb-4">

    {{-- HEATER --}}
    <div class="col-md-4">
        <div class="card toggle-card p-4 text-center">
            <div class="section-title justify-content-center">
                <i class="fa-solid fa-fire text-danger"></i>Heater
            </div>
            <hr class="my-2 opacity-10">
            <div class="icon-circle {{ $kontrol->heater == 'ON' ? 'active-heater' : 'inactive-heater' }}">
                <i class="fa-solid fa-fire-flame-curved {{ $kontrol->heater == 'ON' ? 'fa-bounce' : '' }}"></i>
            </div>
            <div class="status-badge {{ $kontrol->heater == 'ON' ? 'on' : 'off' }}">
                <i class="fa-solid {{ $kontrol->heater == 'ON' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                <span>{{ $kontrol->heater }}</span>
            </div>
            <form action="/heater" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $kontrol->heater == 'ON' ? 'OFF' : 'ON' }}">
                <button type="submit" class="btn w-100 py-2.5 rounded-pill fw-semibold {{ $kontrol->heater == 'ON' ? 'btn-danger shadow-sm' : 'btn-outline-secondary' }}">
                    {{ $kontrol->heater == 'ON' ? '🔴 Matikan' : '🟢 Hidupkan' }}
                </button>
            </form>
        </div>
    </div>

    {{-- MOTOR --}}
    <div class="col-md-4">
        <div class="card toggle-card p-4 text-center">
            <div class="section-title justify-content-center">
                <i class="fa-solid fa-gear text-purple"></i>Motor Putar Telur
            </div>
            <hr class="my-2 opacity-10">
            <div class="icon-circle {{ $kontrol->motor == 'ON' ? 'active-motor' : 'inactive-motor' }}">
                <i class="fa-solid fa-gear {{ $kontrol->motor == 'ON' ? 'fa-spin' : '' }}"></i>
            </div>
            <div class="status-badge {{ $kontrol->motor == 'ON' ? 'on' : 'off' }}">
                <i class="fa-solid {{ $kontrol->motor == 'ON' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                <span>{{ $kontrol->motor }}</span>
            </div>
            <form action="/motor" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $kontrol->motor == 'ON' ? 'OFF' : 'ON' }}">
                <button type="submit" class="btn w-100 py-2.5 rounded-pill fw-semibold {{ $kontrol->motor == 'ON' ? 'btn-warning text-dark shadow-sm' : 'btn-outline-secondary' }}">
                    {{ $kontrol->motor == 'ON' ? '🔴 Matikan' : '🟢 Hidupkan' }}
                </button>
            </form>
        </div>
    </div>

    {{-- KIPAS --}}
    <div class="col-md-4">
        <div class="card toggle-card p-4 text-center">
            <div class="section-title justify-content-center">
                <i class="fa-solid fa-wind text-info"></i>Kipas
            </div>
            <hr class="my-2 opacity-10">
            <div class="icon-circle {{ $kontrol->kipas == 'ON' ? 'active-kipas' : 'inactive-kipas' }}">
                <i class="fa-solid fa-fan {{ $kontrol->kipas == 'ON' ? 'fa-spin' : '' }}"></i>
            </div>
            <div class="status-badge {{ $kontrol->kipas == 'ON' ? 'on' : 'off' }}">
                <i class="fa-solid {{ $kontrol->kipas == 'ON' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                <span>{{ $kontrol->kipas }}</span>
            </div>
            <form action="/kipas" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $kontrol->kipas == 'ON' ? 'OFF' : 'ON' }}">
                <button type="submit" class="btn w-100 py-2.5 rounded-pill fw-semibold {{ $kontrol->kipas == 'ON' ? 'btn-info text-white shadow-sm' : 'btn-outline-secondary' }}">
                    {{ $kontrol->kipas == 'ON' ? '🔴 Matikan' : '🟢 Hidupkan' }}
                </button>
            </form>
        </div>
    </div>

</div>

{{-- ─── TABEL SETTING SAAT INI ─────────────────────────── --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
        <h6 class="mb-0 fw-bold text-dark">
            <i class="fa-solid fa-sliders text-secondary me-2"></i>Konfigurasi Aktif Saat Ini
        </h6>
    </div>
    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="py-3">Target Suhu</th>
                    <th class="py-3">Target Kelembapan</th>
                    <th class="py-3">Mode Operasi</th>
                    <th class="py-3">Terakhir Diubah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-3 fw-bold text-danger">
                        <i class="fa-solid fa-temperature-half me-1"></i>{{ $kontrol->target_suhu }} °C
                    </td>
                    <td class="py-3 fw-bold text-primary">
                        <i class="fa-solid fa-droplet me-1"></i>{{ $kontrol->target_kelembapan }} %
                    </td>
                    <td class="py-3">
                        <span class="badge {{ $kontrol->mode == 'Otomatis' ? 'badge-soft-success' : 'badge-soft-warning' }} px-3 py-2 rounded-pill">
                            <i class="fa-solid {{ $kontrol->mode == 'Otomatis' ? 'fa-robot' : 'fa-hand' }} me-1"></i>{{ $kontrol->mode }}
                        </span>
                    </td>
                    <td class="py-3 text-secondary">
                        <i class="fa-regular fa-clock me-1"></i>{{ $kontrol->updated_at ? \Carbon\Carbon::parse($kontrol->updated_at)->format('d/m/Y H:i') : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection