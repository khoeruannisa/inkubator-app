<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Inkubator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">Riwayat Inkubator</span>
    <a href="/dashboard" class="btn btn-light btn-sm">Dashboard</a>
  </div>
</nav>
<head>
    <meta charset="UTF-8">
    <title>Kontrol Inkubator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#dbeafe,#bfdbfe,#93c5fd);
            min-height:100vh;
        }
        </style>
</head>

<div class="container mt-4">
    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4>Data Per Hari / Jam</h4>
        </div>

        <div class="card-body">

            <!-- 🔍 FILTER TANGGAL -->
            <form method="GET" action="/riwayat">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" name="tanggal" class="form-control"
                            value="{{ $tanggal }}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary">🔍 Filter</button>
                        <a href="/riwayat" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <hr>

            <!-- 📊 TABEL -->
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Suhu</th>
                        <th>Kelembapan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->suhu }} °C</td>
                        <td>{{ $item->kelembapan ?? '-' }} %</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

</body>
</html>