<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🥚 Inkubator Telur</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            font-family: 'Inter', Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f1f5f9;
        }

        /* ─── SIDEBAR ─────────────────────── */
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #0f172a, #1e293b);
            color: white;
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            margin: 6px 0;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar a:hover {
            color: white;
            background: rgba(255,255,255,0.08);
        }

        .sidebar a.active {
            color: white;
            background: rgba(59,130,246,0.3);
        }

        .sidebar-logout {
            margin-top: auto;
        }

        /* ─── CONTENT ─────────────────────── */
        .content {
            margin-left: 220px;
            padding: 28px;
            min-height: 100vh;
        }

        /* ─── CARDS ───────────────────────── */
        .card-box {
            border-radius: 15px;
            padding: 20px;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* ─── ALERTS ──────────────────────── */
        .alert {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">🥚 Inkubator</div>

    <a href="/dashboard" {{ request()->is('dashboard') ? 'class=active' : '' }}>
        📊 Dashboard
    </a>
    <a href="/kontrol" {{ request()->is('kontrol') ? 'class=active' : '' }}>
        🎛️ Kontrol
    </a>
    <a href="/riwayat" {{ request()->is('riwayat') ? 'class=active' : '' }}>
        📋 Riwayat
    </a>

    <div class="sidebar-logout">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn btn-danger w-100" style="font-size:14px;">
                🚪 Logout
            </button>
        </form>
    </div>
</div>

<!-- CONTENT -->
<div class="content">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>