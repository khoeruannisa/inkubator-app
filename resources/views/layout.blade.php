<!DOCTYPE html>
<html>
<head>
    <title>Inkubator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f1f5f9;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(#0f172a, #1e293b);
            color: white;
            padding: 20px;
        }

        .sidebar h4 {
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #cbd5f5;
            margin: 10px 0;
            text-decoration: none;
        }

        .sidebar a:hover {
            color: white;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .card-box {
            border-radius: 15px;
            padding: 20px;
            color: white;
        }

        

        .bg-red { background: #ef4444; }
        .bg-blue { background: #3b82f6; }
        .bg-green { background: #22c55e; }
        .bg-purple { background: #8b5cf6; }
        .bg-warning { background: #facc15; color: black; }

        
    </style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>🔥 Inkubator</h4>
    <a href="/dashboard">Dashboard</a>
    <a href="/kontrol">Kontrol</a>
    <a href="/riwayat">Riwayat</a>
    <a href="/logout" class="btn btn-danger mt-3">Logout</a>

</div>

<!-- CONTENT -->
<div class="content">
    @yield('content')
</div>

</body>
</html>