<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🥚 Inkubator Telur Pintar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: rgba(79, 70, 229, 0.1);
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --dark: #0f172a;
            --light: #f8fafc;
            --sidebar-width: 260px;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -6px rgba(0, 0, 0, 0.1);
        }

        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            margin: 0;
            background-color: #f3f4f6;
            color: #1f2937;
            overflow-x: hidden;
        }

        /* ─── SIDEBAR ─────────────────────── */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(185deg, #1e293b 0%, #0f172a 100%);
            color: #94a3b8;
            padding: 30px 24px;
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 35px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            letter-spacing: -0.5px;
        }

        .sidebar-brand i {
            color: var(--warning);
            filter: drop-shadow(0 2px 8px rgba(245, 158, 11, 0.4));
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            margin: 8px 0;
            padding: 12px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar a i {
            font-size: 18px;
            transition: transform 0.25s ease;
        }

        .sidebar a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar a:hover i {
            transform: translateX(3px);
        }

        .sidebar a.active {
            color: #ffffff;
            background: var(--primary);
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        .sidebar a.active i {
            color: #ffffff;
        }

        .sidebar-logout {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 20px;
        }

        .sidebar-logout button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            border-radius: 12px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }

        .sidebar-logout button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.25);
        }

        /* ─── CONTENT ─────────────────────── */
        .content {
            margin-left: var(--sidebar-width);
            padding: 40px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* ─── MOBILE HEADER & OVERLAY ──────── */
        .mobile-header {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: #1e293b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 90;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 95;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 100;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
                padding: 20px;
                padding-top: 24px;
            }
        }

        /* ─── CARDS ───────────────────────── */
        .card {
            border: none;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        /* ─── ALERTS ──────────────────────── */
        .alert {
            border: none;
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border-left: 5px solid #10b981;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 5px solid #ef4444;
        }

        .alert .btn-close {
            margin-left: auto;
            padding: 0;
            box-shadow: none;
        }
    </style>
</head>

<body>

<!-- MOBILE HEADER -->
<div class="mobile-header d-lg-none">
    <button id="sidebarToggle" class="btn text-white p-0 border-0">
        <i class="fa-solid fa-bars fs-4"></i>
    </button>
    <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-egg text-warning fs-5"></i>
        <span class="fw-bold">Inkubator Telur</span>
    </div>
    <div style="width: 24px;"></div>
</div>

<!-- OVERLAY BACKDROP -->
<div id="sidebarOverlay" class="sidebar-overlay"></div>

<!-- SIDEBAR -->
<div id="sidebarMenu" class="sidebar">
    <div class="sidebar-brand d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-egg fa-bounce"></i>
            <span>Inkubator Telur</span>
        </div>
        <button id="sidebarClose" class="btn btn-link text-white d-lg-none p-0 border-0">
            <i class="fa-solid fa-xmark fs-4"></i>
        </button>
    </div>

    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-simple"></i>
        <span>Dashboard</span>
    </a>
    <a href="/kontrol" class="{{ request()->is('kontrol') ? 'active' : '' }}">
        <i class="fa-solid fa-sliders"></i>
        <span>Kontrol Parameter</span>
    </a>
    <a href="/riwayat" class="{{ request()->is('riwayat') ? 'active' : '' }}">
        <i class="fa-solid fa-clock-rotate-left"></i>
        <span>Riwayat Sensor</span>
    </a>

    <div style="height:1px;background:rgba(255,255,255,0.06);margin:12px 0;"></div>
    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#475569;padding:4px 16px 8px;">Akun</div>

    <a href="/register" class="{{ request()->is('register') ? 'active' : '' }}">
        <i class="fa-solid fa-user-plus"></i>
        <span>Tambah User</span>
    </a>

    <div class="sidebar-logout">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- CONTENT -->
<div class="content">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fa-solid fa-circle-check fs-5"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fa-solid fa-circle-exclamation fs-5"></i>
            <div>
                <strong>Error!</strong> {{ session('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SIDEBAR RESPONSIVE SCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById("sidebarToggle");
        const closeBtn = document.getElementById("sidebarClose");
        const overlay = document.getElementById("sidebarOverlay");
        const sidebar = document.getElementById("sidebarMenu");

        function openSidebar() {
            sidebar.classList.add("active");
            overlay.classList.add("active");
            document.body.style.overflow = "hidden"; // disable scrolling
        }

        function closeSidebar() {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
            document.body.style.overflow = ""; // enable scrolling
        }

        if (toggleBtn) toggleBtn.addEventListener("click", openSidebar);
        if (closeBtn) closeBtn.addEventListener("click", closeSidebar);
        if (overlay) overlay.addEventListener("click", closeSidebar);
    });
</script>

</body>
</html>