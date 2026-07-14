<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Inkubator Telur Pintar</title>
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
            background: linear-gradient(145deg, #1e1b4b 0%, #312e81 40%, #4c1d95 100%);
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
            background: radial-gradient(circle, rgba(139,92,246,0.25) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);
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

        .left-feature {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 28px;
            z-index: 1;
            width: 100%;
            max-width: 360px;
        }

        .left-feature-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .left-feature-text h6 {
            color: white;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .left-feature-text p {
            color: rgba(255,255,255,0.5);
            font-size: 12px;
            margin: 0;
            line-height: 1.6;
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
            background: #ede9fe;
            color: #5b21b6;
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
            border-color: #7c3aed;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(124,58,237,0.1);
        }

        .form-input.is-invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239,68,68,0.1);
        }

        .invalid-msg {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-register {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
            border: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px rgba(124,58,237,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(124,58,237,0.4);
            background: linear-gradient(135deg, #6d28d9 0%, #4c1d95 100%);
        }

        .btn-register:active {
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

        .login-link {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .login-link a {
            color: #7c3aed;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: #5b21b6;
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
            border: none;
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

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
                overflow: auto;
            }

            .left-panel {
                padding: 40px 30px;
                min-height: auto;
            }

            .left-panel .left-feature {
                display: none;
            }

            .brand-logo {
                margin-bottom: 0;
            }

            .right-panel {
                width: 100%;
                padding: 40px 30px;
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
            Pantau & Kendalikan<br>Inkubator Anda
        </h3>
        <p style="color:rgba(255,255,255,0.5);font-size:13px;line-height:1.7;margin-bottom:40px;">
            Daftar sekarang dan mulai pantau suhu, kelembapan, serta status perangkat inkubator secara real-time dari mana saja.
        </p>

        <div class="left-feature">
            <div class="left-feature-icon" style="background:rgba(245,158,11,0.15);">
                <i class="fa-solid fa-chart-line" style="color:#fbbf24;"></i>
            </div>
            <div class="left-feature-text">
                <h6>Monitoring Real-time</h6>
                <p>Pantau suhu dan kelembapan inkubator secara langsung dengan grafik interaktif.</p>
            </div>
        </div>

        <div class="left-feature">
            <div class="left-feature-icon" style="background:rgba(16,185,129,0.15);">
                <i class="fa-solid fa-robot" style="color:#34d399;"></i>
            </div>
            <div class="left-feature-text">
                <h6>Kontrol Otomatis</h6>
                <p>Sistem mengatur heater, kipas, dan motor putar secara otomatis sesuai set point.</p>
            </div>
        </div>

        <div class="left-feature">
            <div class="left-feature-icon" style="background:rgba(99,102,241,0.15);">
                <i class="fa-solid fa-clock-rotate-left" style="color:#a5b4fc;"></i>
            </div>
            <div class="left-feature-text">
                <h6>Riwayat Data Lengkap</h6>
                <p>Akses riwayat data sensor kapan saja untuk analisis dan peningkatan kualitas telur.</p>
            </div>
        </div>
    </div>
</div>

<!-- ─── RIGHT PANEL ────────────────────────────────────── -->
<div class="right-panel">
    <div class="form-header">
        <div class="form-header-badge">
            <i class="fa-solid fa-user-plus"></i>Buat Akun Baru
        </div>
        <h2>Daftar Sekarang</h2>
        <p>Isi data di bawah untuk membuat akun dan mulai memantau inkubator Anda.</p>
    </div>

    @if($errors->any())
        <div class="alert-custom alert-danger-custom">
            <i class="fa-solid fa-circle-exclamation mt-1" style="flex-shrink:0;"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-custom alert-success-custom">
            <i class="fa-solid fa-circle-check mt-1" style="flex-shrink:0;"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div class="input-field">
            <label>Nama Lengkap</label>
            <i class="fa-solid fa-user input-icon"></i>
            <input
                type="text"
                name="name"
                class="form-input @error('name') is-invalid @enderror"
                placeholder="Masukkan nama lengkap Anda"
                value="{{ old('name') }}"
                required>
            @error('name')
                <div class="invalid-msg">
                    <i class="fa-solid fa-circle-exclamation"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-field">
            <label>Alamat Email</label>
            <i class="fa-solid fa-envelope input-icon"></i>
            <input
                type="email"
                name="email"
                class="form-input @error('email') is-invalid @enderror"
                placeholder="contoh@email.com"
                value="{{ old('email') }}"
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
                placeholder="Minimal 4 karakter"
                required>
            <div style="font-size:11px;color:#94a3b8;margin-top:6px;">
                <i class="fa-solid fa-info-circle me-1"></i>Gunakan kata sandi yang mudah diingat namun sulit ditebak.
            </div>
        </div>

        <button type="submit" class="btn-register">
            <i class="fa-solid fa-rocket"></i>
            Buat Akun Sekarang
        </button>
    </form>

    <div class="divider">atau</div>

    <div class="login-link">
        @auth
            <a href="/dashboard" class="btn-back-dash">
                <i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Dashboard
            </a>
        @else
            Sudah punya akun? <a href="/login">Masuk di sini</a>
        @endauth
    </div>
</div>

<style>
.btn-back-dash {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    border-radius: 12px;
    background: #f1f5f9;
    color: #334155;
    font-weight: 700;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-back-dash:hover {
    background: #e2e8f0;
    color: #0f172a;
}
</style>

</body>
</html>