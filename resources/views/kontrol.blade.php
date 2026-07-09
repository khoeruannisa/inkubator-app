<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kontrol Inkubator</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">Kontrol Inkubator</span>
    <a href="/dashboard" class="btn btn-light btn-sm">Dashboard</a>
  </div>
</nav>
</head>
<head>
    <meta charset="UTF-8">
    <title>Kontrol Inkubator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#dbeafe,#bfdbfe,#93c5fd);
            min-height:100vh;
        }

        .navbar{
            box-shadow:0 4px 10px rgba(0,0,0,0.2);
        }

        .card{
            border:none;
            border-radius:18px;
            box-shadow:0 8px 20px rgba(0, 189, 157, 0.15);
            transition:.3s;
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .title{
            font-size:22px;
            font-weight:bold;
            color:#0d6efd;
            text-align:center;
        }

        h5{
            text-align:center;
            font-weight:bold;
        }

        .status{
            font-size:24px;
            font-weight:bold;
            text-align:center;
            color:#198754;
            margin:15px 0;
        }

        .btn{
            border-radius:10px;
            font-weight:600;
        }

        label{
            font-weight:600;
        }
    </style>

</head>
<body>

<div class="container mt-4">


    <div class="row">

        <div class="col-md-6 d-flex">

        <div class="card p-4 mb-3 w-100 h-90">

                <div class="title">
                    MODE OPERASI
                </div>

                <hr>

                <form action="/mode" method="POST">

                    @csrf

                    <select class="form-select mb-3" name="mode">

                        <option value="Otomatis"
                        {{ $kontrol->mode=="Otomatis" ? 'selected' : '' }}>
                        Otomatis
                        </option>

                        <option value="Manual"
                        {{ $kontrol->mode=="Manual" ? 'selected' : '' }}>
                        Manual
                        </option>

                    </select>

                    <button class="btn btn-primary w-100">
                        Simpan Mode
                    </button>

                </form>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card p-4 mb-3">

                <div class="title">
                    TARGET
                </div>
                

                <hr>

                <form action="/parameter" method="POST">

                    @csrf

                    <label>Target Suhu</label>

                    <input
                        type="number"
                        step="0.1"
                        name="target_suhu"
                        class="form-control mb-3"
                        value="{{ $kontrol->target_suhu }}">

                    <label>Target Kelembapan</label>

                    <input
                        type="number"
                        name="target_kelembapan"
                        class="form-control mb-3"
                        value="{{ $kontrol->target_kelembapan }}">

                    <button class="btn btn-success w-100">
                        Simpan Parameter
                    </button>

                </form>

            </div>

        </div>

    </div>


    <div class="row">

        <div class="col-md-4">

            <div class="card p-4">

                <h5>HEATER</h5>

                <p class="status">

                    {{ $kontrol->heater }}

                </p>

                <form action="/heater" method="POST">

                    @csrf

                    <input type="hidden" name="status"
                    value="{{ $kontrol->heater=='ON' ? 'OFF' : 'ON' }}">

                    <button class="btn btn-danger w-100">

                        {{ $kontrol->heater=='ON' ? 'Matikan' : 'Hidupkan' }}

                    </button>

                </form>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card p-4">

                <h5>MOTOR</h5>

                <p class="status">

                    {{ $kontrol->motor }}

                </p>

                <form action="/motor" method="POST">

                    @csrf

                    <input type="hidden" name="status"
                    value="{{ $kontrol->motor=='ON' ? 'OFF' : 'ON' }}">

                    <button class="btn btn-warning w-100">

                        {{ $kontrol->motor=='ON' ? 'Matikan' : 'Hidupkan' }}

                    </button>

                </form>

            </div>

        </div>
        


        <div class="col-md-4">

            <div class="card p-4">

                <h5>KIPAS</h5>

                <p class="status">

                    {{ $kontrol->kipas }}

                </p>

                <form action="/kipas" method="POST">

                    @csrf

                    <input type="hidden" name="status"
                    value="{{ $kontrol->kipas=='ON' ? 'OFF' : 'ON' }}">

                    <button class="btn btn-success w-100">

                        {{ $kontrol->kipas=='ON' ? 'Matikan' : 'Hidupkan' }}

                    </button>

                </form>

            </div>

        </div>
        <div class="row mt-4">
    <div class="col-md-12">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Data Setting yang Tersimpan</h5>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped text-center">

                    <thead class="table-light">

                        <tr>
                            <th>No</th>
                            <th>Target Suhu (°C)</th>
                            <th>Target Kelembapan (%)</th>
                            <th>Mode Operasi</th>
                            <th>Terakhir Diubah</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>{{ $kontrol->target_suhu }}</td>
                            <td>{{ $kontrol->target_kelembapan }}</td>
                            <td>{{ $kontrol->mode }}</td>
                            <td>{{ $kontrol->updated_at }}</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

    </div>

</div>

</body>
</html>