<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Inkubator Telur Pintar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            overflow: hidden;
        }

        /* ─── LEFT PANEL ─── */
        .left-panel {
            flex: 1;
            background: linear-gradient(145deg, #0c1a3a 0%, #1e3a5f 40%, #1e40af 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 50px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            border-radius: 50%;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 60px;
            z-index: 1;
        }

        .brand-logo-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 8px 20px rgba(245,158,11,0.4);
        }

        .brand-logo-text {
            color: white;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .brand-logo-text span {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0;
        }

        /* Stats floating cards */
        .stat-float {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
            width: 100%;
            max-width: 360px;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .stat-float:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(4px);
        }

        .stat-float-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .stat-float-content h6 {
            color: white;
            font-weight: 700;
            font-size: 13px;
            margin: 0 0 2px;
        }

        .stat-float-content p {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
            margin: 0;
        }

        /* ─── RIGHT PANEL ─── */
        .right-panel {
            width: 480px;
            flex-shrink: 0;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
            overflow-y: auto;
        }

        .form-header {
            margin-bottom: 36px;
        }

        .form-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #dbeafe;
            color: #1e40af;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 16px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.8px;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .form-header p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }

        .input-field {
            position: relative;
            margin-bottom: 18px;
        }

        .input-field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 8px;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            bottom: 14px;
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 13px 16px 13px 46px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 500;
            color: #0f172a;
            background: #f8fafc;
            transition: all 0.2s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }

        .form-input.is-invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .invalid-msg {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px rgba(37,99,235,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(37,99,235,0.4);
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            color: #cbd5e1;
            font-size: 12px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .register-link {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .register-link a {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .register-link a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .alert-custom {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }

        .alert-danger-custom {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-success-custom {
            background: #ecfdf5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        /* Security badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 24px;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
                overflow: auto;
            }

            .left-panel {
                padding: 36px 28px;
                min-height: auto;
            }

            .left-panel .stat-float {
                display: none;
            }

            .brand-logo {
                margin-bottom: 0;
            }

            .right-panel {
                width: 100%;
                padding: 40px 28px;
            }
        }
    </style>
</head>
<body>

<!-- ─── LEFT PANEL ─────────────────────────────────────── -->
<div class="left-panel d-none d-md-flex">
    <div class="brand-logo">
        <div class="brand-logo-icon">
            <i class="fa-solid fa-egg"></i>
        </div>
        <div class="brand-logo-text">
            Inkubator Pintar
            <span>Sistem Pemantauan Telur</span>
        </div>
    </div>

    <div style="width:100%;max-width:360px;z-index:1;">
        <h3 style="color:white;font-weight:800;font-size:26px;margin-bottom:12px;letter-spacing:-0.5px;">
            Selamat Datang<br>Kembali 👋
        </h3>
        <p style="color:rgba(255,255,255,0.5);font-size:13px;line-height:1.7;margin-bottom:36px;">
            Masuk untuk memantau dan mengelola inkubator telur Anda secara real-time.
        </p>

        <div class="stat-float">
            <div class="stat-float-icon" style="background:rgba(245,158,11,0.15);">
                <i class="fa-solid fa-temperature-three-quarters" style="color:#fbbf24;"></i>
            </div>
            <div class="stat-float-content">
                <h6>Monitoring Suhu & Kelembapan</h6>
                <p>Pantau kondisi inkubator secara real-time</p>
            </div>
        </div>

        <div class="stat-float">
            <div class="stat-float-icon" style="background:rgba(16,185,129,0.15);">
                <i class="fa-solid fa-chart-area" style="color:#34d399;"></i>
            </div>
            <div class="stat-float-content">
                <h6>Grafik Interaktif</h6>
                <p>Visualisasi tren data sensor 100 data terakhir</p>
            </div>
        </div>

        <div class="stat-float">
            <div class="stat-float-icon" style="background:rgba(139,92,246,0.15);">
                <i class="fa-solid fa-sliders" style="color:#c4b5fd;"></i>
            </div>
            <div class="stat-float-content">
                <h6>Kontrol Parameter</h6>
                <p>Atur set point suhu dan kelembapan dengan mudah</p>
            </div>
        </div>

        <div class="stat-float">
            <div class="stat-float-icon" style="background:rgba(6,182,212,0.15);">
                <i class="fa-solid fa-clock-rotate-left" style="color:#67e8f9;"></i>
            </div>
            <div class="stat-float-content">
                <h6>Riwayat Data Lengkap</h6>
                <p>Akses histori sensor kapan saja</p>
            </div>
        </div>
    </div>
</div>

<!-- ─── RIGHT PANEL ────────────────────────────────────── -->
<div class="right-panel">
    <div class="form-header">
        <div class="form-header-badge">
            <i class="fa-solid fa-lock"></i>Login Akun
        </div>
        <h2>Masuk ke Dashboard</h2>
        <p>Gunakan email dan kata sandi yang telah Anda daftarkan sebelumnya.</p>
    </div>

    @if(session('error'))
        <div class="alert-custom alert-danger-custom">
            <i class="fa-solid fa-circle-exclamation mt-1" style="flex-shrink:0;"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-custom alert-success-custom">
            <i class="fa-solid fa-circle-check mt-1" style="flex-shrink:0;"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="input-field">
            <label>Alamat Email</label>
            <i class="fa-solid fa-envelope input-icon"></i>
            <input
                type="email"
                name="email"
                class="form-input @error('email') is-invalid @enderror"
                placeholder="contoh@email.com"
                value="{{ old('email') }}"
                autocomplete="email"
                required>
            @error('email')
                <div class="invalid-msg">
                    <i class="fa-solid fa-circle-exclamation"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-field" style="margin-bottom: 28px;">
            <label>Kata Sandi</label>
            <i class="fa-solid fa-lock input-icon"></i>
            <input
                type="password"
                name="password"
                class="form-input"
                placeholder="Masukkan kata sandi"
                autocomplete="current-password"
                required>
        </div>

        <button type="submit" class="btn-login">
            <i class="fa-solid fa-right-to-bracket"></i>
            Masuk Sekarang
        </button>
    </form>

    <div class="divider">atau</div>

    <div class="register-link">
        Belum punya akun? <a href="/register">Daftar gratis</a>
    </div>

    <div class="security-badge">
        <i class="fa-solid fa-shield-halved"></i>
        Koneksi aman & terenkripsi
    </div>
</div>

</body>
</html>