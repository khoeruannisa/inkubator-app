@extends('layout')

@section('content')

<h4 class="mb-4 fw-bold">🎛️ Kontrol Inkubator</h4>

<style>
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-3px);
    }

    .section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 4px;
    }

    .status-badge {
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        margin: 12px 0;
    }

    .on  { color: #16a34a; }
    .off { color: #6b7280; }
</style>

{{-- ─── BARIS 1: Mode & Target ───────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- MODE OPERASI --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="section-title">⚙️ Mode Operasi</div>
            <hr class="my-2">

            @if(session('success'))
                <div class="alert alert-success py-2 small">{{ session('success') }}</div>
            @endif

            <form action="/mode" method="POST">
                @csrf
                <select class="form-select mb-3" name="mode">
                    <option value="Otomatis" {{ $kontrol->mode == 'Otomatis' ? 'selected' : '' }}>
                        🤖 Otomatis
                    </option>
                    <option value="Manual" {{ $kontrol->mode == 'Manual' ? 'selected' : '' }}>
                        🖐️ Manual
                    </option>
                </select>
                <button class="btn btn-primary w-100">Simpan Mode</button>
            </form>
        </div>
    </div>

    {{-- TARGET PARAMETER --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="section-title">🎯 Target Parameter</div>
            <hr class="my-2">

            <form action="/parameter" method="POST">
                @csrf
                <label class="form-label fw-600 small">Suhu Target (°C)</label>
                <input
                    type="number"
                    step="0.1"
                    name="target_suhu"
                    class="form-control mb-3"
                    value="{{ $kontrol->target_suhu }}"
                    min="30" max="45"
                    required>

                <label class="form-label fw-600 small">Kelembapan Target (%)</label>
                <input
                    type="number"
                    name="target_kelembapan"
                    class="form-control mb-3"
                    value="{{ $kontrol->target_kelembapan }}"
                    min="40" max="90"
                    required>

                <button class="btn btn-success w-100">Simpan Parameter</button>
            </form>
        </div>
    </div>

</div>

{{-- ─── BARIS 2: Toggle Perangkat ───────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- HEATER --}}
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div class="section-title">🔥 Heater</div>
            <hr class="my-2">
            <div class="status-badge {{ $kontrol->heater == 'ON' ? 'on' : 'off' }}">
                {{ $kontrol->heater }}
            </div>
            <form action="/heater" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $kontrol->heater == 'ON' ? 'OFF' : 'ON' }}">
                <button class="btn w-100 {{ $kontrol->heater == 'ON' ? 'btn-danger' : 'btn-outline-success' }}">
                    {{ $kontrol->heater == 'ON' ? '🔴 Matikan' : '🟢 Hidupkan' }}
                </button>
            </form>
        </div>
    </div>

    {{-- MOTOR --}}
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div class="section-title">⚙️ Motor Putar Telur</div>
            <hr class="my-2">
            <div class="status-badge {{ $kontrol->motor == 'ON' ? 'on' : 'off' }}">
                {{ $kontrol->motor }}
            </div>
            <form action="/motor" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $kontrol->motor == 'ON' ? 'OFF' : 'ON' }}">
                <button class="btn w-100 {{ $kontrol->motor == 'ON' ? 'btn-warning' : 'btn-outline-warning' }}">
                    {{ $kontrol->motor == 'ON' ? '🔴 Matikan' : '🟢 Hidupkan' }}
                </button>
            </form>
        </div>
    </div>

    {{-- KIPAS --}}
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div class="section-title">💨 Kipas</div>
            <hr class="my-2">
            <div class="status-badge {{ $kontrol->kipas == 'ON' ? 'on' : 'off' }}">
                {{ $kontrol->kipas }}
            </div>
            <form action="/kipas" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $kontrol->kipas == 'ON' ? 'OFF' : 'ON' }}">
                <button class="btn w-100 {{ $kontrol->kipas == 'ON' ? 'btn-info' : 'btn-outline-info' }}">
                    {{ $kontrol->kipas == 'ON' ? '🔴 Matikan' : '🟢 Hidupkan' }}
                </button>
            </form>
        </div>
    </div>

</div>

{{-- ─── TABEL SETTING SAAT INI ─────────────────────────── --}}
<div class="card">
    <div class="card-header bg-dark text-white">
        <h6 class="mb-0">📋 Setting Saat Ini</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th>Target Suhu (°C)</th>
                    <th>Target Kelembapan (%)</th>
                    <th>Mode</th>
                    <th>Terakhir Diubah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ $kontrol->target_suhu }}</strong></td>
                    <td><strong>{{ $kontrol->target_kelembapan }}</strong></td>
                    <td>
                        <span class="badge {{ $kontrol->mode == 'Otomatis' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $kontrol->mode }}
                        </span>
                    </td>
                    <td>{{ $kontrol->updated_at ? \Carbon\Carbon::parse($kontrol->updated_at)->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection