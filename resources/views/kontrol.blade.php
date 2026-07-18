@extends('layout')

@section('content')

<h4 class="mb-4 fw-bold">🎛️ Kontrol Inkubator</h4>

<style>

.card{
    border:none;
    border-radius:18px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
    transition:.3s;
}

.card:hover{
    transform:translateY(-3px);
}

.section-title{
    font-size:13px;
    font-weight:bold;
    color:#64748b;
    text-transform:uppercase;
    letter-spacing:.08em;
}

.status-badge{
    font-size:22px;
    font-weight:bold;
    margin:15px 0;
}

.on{
    color:#16a34a;
}

.off{
    color:#6b7280;
}

.card-icon{
    width:45px;
    height:45px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    color:white;
    margin-bottom:15px;
}

.bg-heater{
    background:#ef4444;
}

.bg-fan{
    background:#3b82f6;
}

.bg-motor{
    background:#8b5cf6;
}

</style>

<div class="row mb-4">

    <div class="col-md-12">

        <div class="card p-4">

            <div class="section-title">
                ⚙️ MODE OPERASI
            </div>

            <hr>

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <form action="/mode" method="POST">

                @csrf

                <label class="form-label">
                    Pilih Mode Sistem
                </label>

                <select class="form-select mb-3" name="mode">

                    <option value="Otomatis"
                    {{ $kontrol->mode=="Otomatis" ? "selected":"" }}>

                        🤖 Mode Otomatis

                    </option>

                    <option value="Manual"
                    {{ $kontrol->mode=="Manual" ? "selected":"" }}>

                        🖐️ Mode Manual

                    </option>

                </select>

                <button class="btn btn-primary w-100">

                    Simpan Mode

                </button>

            </form>

        </div>

    </div>

</div>

@if($kontrol->mode == 'Otomatis')

<!-- Isi tampilan Mode Otomatis -->

<div class="row">

    <!-- Target Parameter -->
    <div class="col-md-6">

        <div class="card p-4">

            <div class="section-title">
                🎯 TARGET PARAMETER
            </div>

            <hr>

            <form action="/parameter" method="POST">

                @csrf

                <label class="form-label">
                    Target Suhu (°C)
                </label>

                <input
                    type="number"
                    step="0.1"
                    class="form-control mb-3"
                    name="target_suhu"
                    value="{{ $kontrol->target_suhu }}"
                >

                <label class="form-label">
                    Target Kelembapan (%)
                </label>

                <input
                    type="number"
                    class="form-control mb-3"
                    name="target_kelembapan"
                    value="{{ $kontrol->target_kelembapan }}"
                >

                <button class="btn btn-success w-100">

                    Simpan Parameter

                </button>

            </form>

        </div>

    </div>

    <!-- Status -->
    <div class="col-md-6">

        <div class="card p-4">

            <div class="section-title">

                📋 STATUS OTOMATIS

            </div>

            <hr>

            <table class="table">

                <tr>

                    <td>Mode</td>

                    <td>
                        <span class="badge bg-success">
                            {{ $kontrol->mode }}
                        </span>
                    </td>

                </tr>

                <tr>

                    <td>Heater</td>

                    <td>{{ $kontrol->heater }}</td>

                </tr>

                <tr>

                    <td>Motor</td>

                    <td>{{ $kontrol->motor }}</td>

                </tr>

                <tr>

                    <td>Kipas</td>

                    <td>{{ $kontrol->kipas }}</td>

                </tr>

            </table>

        </div>

    </div>

</div>

<div class="alert alert-success mt-3">

🤖 Mode Otomatis aktif.<br>

ESP8266 akan mengontrol Heater, Motor, dan Kipas secara otomatis berdasarkan parameter yang telah disimpan.

</div>


@endif

@if($kontrol->mode == 'Manual')

<!-- Isi tampilan Mode Manual -->

<div class="row g-3">

    <!-- HEATER -->
    <div class="col-md-4">

        <div class="card p-4 text-center">

            <div class="card-icon bg-heater">
                🔥
            </div>

            <div class="section-title">
                HEATER
            </div>

            <div class="status-badge {{ $kontrol->heater=='ON' ? 'on':'off' }}">

                {{ $kontrol->heater }}

            </div>

            <form action="/heater" method="POST">

                @csrf

                <input
                    type="hidden"
                    name="status"
                    value="{{ $kontrol->heater=='ON' ? 'OFF':'ON' }}">

                <button class="btn {{ $kontrol->heater=='ON' ? 'btn-danger':'btn-success' }} w-100">

                    {{ $kontrol->heater=='ON' ? 'Matikan Heater':'Hidupkan Heater' }}

                </button>

            </form>

        </div>

    </div>


    <!-- MOTOR -->
    <div class="col-md-4">

        <div class="card p-4 text-center">

            <div class="card-icon bg-motor">
                ⚙️
            </div>

            <div class="section-title">
                MOTOR PUTAR
            </div>

            <div class="status-badge {{ $kontrol->motor=='ON' ? 'on':'off' }}">

                {{ $kontrol->motor }}

            </div>

            <form action="/motor" method="POST">

                @csrf

                <input
                    type="hidden"
                    name="status"
                    value="{{ $kontrol->motor=='ON' ? 'OFF':'ON' }}">

                <button class="btn btn-warning w-100">

                    {{ $kontrol->motor=='ON' ? 'Matikan Motor':'Hidupkan Motor' }}

                </button>

            </form>

        </div>

    </div>


    <!-- KIPAS -->
    <div class="col-md-4">

        <div class="card p-4 text-center">

            <div class="card-icon bg-fan">
                💨
            </div>

            <div class="section-title">
                KIPAS
            </div>

            <div class="status-badge {{ $kontrol->kipas=='ON' ? 'on':'off' }}">

                {{ $kontrol->kipas }}

            </div>

            <form action="/kipas" method="POST">

                @csrf

                <input
                    type="hidden"
                    name="status"
                    value="{{ $kontrol->kipas=='ON' ? 'OFF':'ON' }}">

                <button class="btn btn-info text-white w-100">

                    {{ $kontrol->kipas=='ON' ? 'Matikan Kipas':'Hidupkan Kipas' }}

                </button>

            </form>

        </div>

    </div>

</div>

<div class="alert alert-warning mt-4">

<b>🖐️ Mode Manual Aktif</b>

<br>

Semua perangkat dikendalikan langsung melalui website.
ESP8266 hanya menjalankan perintah yang dikirim dari website.

</div>

@endif

<div class="card mt-4">

    <div class="card-header bg-dark text-white">

        <h6 class="mb-0">
            📋 Setting Saat Ini
        </h6>

    </div>

    <div class="card-body p-0">

        <table class="table table-bordered table-striped text-center mb-0">

            <thead class="table-light">

                <tr>

                    <th>Target Suhu</th>
                    <th>Target Kelembapan</th>
                    <th>Mode</th>
                    <th>Heater</th>
                    <th>Motor</th>
                    <th>Kipas</th>
                    <th>Terakhir Diubah</th>

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

                    <td>{{ $kontrol->heater }}</td>

                    <td>{{ $kontrol->motor }}</td>

                    <td>{{ $kontrol->kipas }}</td>

                    <td>

                        {{ $kontrol->updated_at
                            ? \Carbon\Carbon::parse($kontrol->updated_at)->format('d-m-Y H:i')
                            : '-'
                        }}

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsectiong