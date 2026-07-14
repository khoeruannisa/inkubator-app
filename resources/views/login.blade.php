<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke sistem monitoring inkubator telur pintar">
    <title>Login — Inkubator Telur Pintar</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --blue-deep:   #0f1f3d;
            --blue-mid:    #1a3a6b;
            --blue-accent: #2563eb;
            --blue-light:  #3b82f6;
            --amber:       #f59e0b;
            --amber-glow:  rgba(245,158,11,0.45);
            --white:       #ffffff;
            --slate-50:    #f8fafc;
            --slate-100:   #f1f5f9;
            --slate-200:   #e2e8f0;
            --slate-400:   #94a3b8;
            --slate-600:   #475569;
            --slate-800:   #1e293b;
            --slate-900:   #0f172a;
            --radius-sm:   10px;
            --radius-md:   16px;
            --radius-lg:   22px;
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            display: grid;
            grid-template-columns: 1fr 480px;
            min-height: 100vh;
            background: var(--slate-900);
        }

        /* ══════════════════════════════════════
           HERO PANEL (kiri)
        ══════════════════════════════════════ */
        .hero {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 64px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue-mid) 60%, #1e3a8a 100%);
        }

        /* Animated orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: float 8s ease-in-out infinite;
        }
        .orb-1 {
            width: 420px; height: 420px;
            background: radial-gradient(circle, rgba(37,99,235,0.35), transparent 70%);
            top: -120px; right: -80px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(245,158,11,0.2), transparent 70%);
            bottom: -60px; left: -40px;
            animation-delay: -3s;
        }
        .orb-3 {
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(99,102,241,0.25), transparent 70%);
            top: 40%; left: 20%;
            animation-delay: -6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }

        /* Grid dots background */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 460px;
        }

        .hero-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 56px;
        }

        .hero-brand-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--amber), #d97706);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
            box-shadow: 0 0 0 3px rgba(245,158,11,0.25), 0 8px 24px var(--amber-glow);
            animation: pulse-amber 3s ease-in-out infinite;
        }

        @keyframes pulse-amber {
            0%, 100% { box-shadow: 0 0 0 3px rgba(245,158,11,0.25), 0 8px 24px var(--amber-glow); }
            50% { box-shadow: 0 0 0 6px rgba(245,158,11,0.15), 0 12px 32px var(--amber-glow); }
        }

        .hero-brand-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.1;
            letter-spacing: -0.3px;
        }

        .hero-brand-name small {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0;
        }

        .hero-title {
            font-size: clamp(28px, 3.5vw, 38px);
            font-weight: 800;
            color: var(--white);
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 16px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #93c5fd, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 15px;
            color: rgba(255,255,255,0.5);
            line-height: 1.7;
            margin-bottom: 48px;
            max-width: 380px;
        }

        /* Feature cards */
        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: var(--radius-md);
            backdrop-filter: blur(8px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
        }

        .feature-card:hover {
            background: rgba(255,255,255,0.09);
            border-color: rgba(255,255,255,0.14);
            transform: translateX(6px);
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .feature-text h6 {
            font-size: 13px;
            font-weight: 700;
            color: var(--white);
            margin: 0 0 3px;
        }

        .feature-text p {
            font-size: 11.5px;
            color: rgba(255,255,255,0.45);
            margin: 0;
            line-height: 1.5;
        }

        /* ══════════════════════════════════════
           FORM PANEL (kanan)
        ══════════════════════════════════════ */
        .form-panel {
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 56px 48px;
            overflow-y: auto;
            position: relative;
        }

        /* Top decoration line */
        .form-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--blue-accent), #818cf8, var(--amber));
        }

        .form-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 20px;
            width: fit-content;
        }

        .form-title {
            font-size: clamp(22px, 2.5vw, 28px);
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.7px;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--slate-400);
            margin-bottom: 36px;
            line-height: 1.6;
        }

        /* Alert */
        .alert-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            margin-bottom: 22px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-box.danger {
            background: #fff1f2;
            color: #9f1239;
            border-left: 4px solid #f43f5e;
        }

        .alert-box.success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-box i { flex-shrink: 0; margin-top: 1px; }

        /* Input fields */
        .field {
            margin-bottom: 20px;
        }

        .field-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--slate-600);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 9px;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--slate-400);
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .field-input {
            width: 100%;
            padding: 14px 44px 14px 46px;
            border: 2px solid var(--slate-200);
            border-radius: var(--radius-sm);
            font-size: 14.5px;
            font-weight: 500;
            color: var(--slate-900);
            background: var(--slate-50);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.22s ease;
            -webkit-appearance: none;
        }

        .field-input::placeholder { color: var(--slate-400); }

        .field-input:focus {
            outline: none;
            border-color: var(--blue-accent);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
        }

        .field-input:focus + .field-icon,
        .field-wrap:focus-within .field-icon {
            color: var(--blue-accent);
        }

        .field-input.invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .field-input.invalid:focus {
            box-shadow: 0 0 0 4px rgba(239,68,68,0.1);
        }

        .eye-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--slate-400);
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: color 0.2s ease;
            font-size: 14px;
        }

        .eye-btn:hover { color: var(--slate-600); }

        .error-msg {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #ef4444;
            margin-top: 7px;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%);
            background-size: 200% 200%;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(37,99,235,0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 0.01em;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(37,99,235,0.45);
        }

        .btn-submit:hover::after { opacity: 1; }
        .btn-submit:active { transform: translateY(0); }

        /* Divider */
        .or-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 26px 0;
            font-size: 12px;
            color: var(--slate-400);
            font-weight: 600;
        }

        .or-divider::before, .or-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--slate-200);
        }

        /* Bottom link */
        .bottom-link {
            text-align: center;
            font-size: 14px;
            color: var(--slate-400);
            font-weight: 500;
        }

        .bottom-link a {
            color: var(--blue-accent);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .bottom-link a:hover { color: #1d4ed8; text-decoration: underline; }

        /* Security note */
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 11px;
            color: var(--slate-400);
            margin-top: 20px;
        }

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */

        /* Large tablet: shrink form panel */
        @media (max-width: 1024px) {
            body { grid-template-columns: 1fr 420px; }
            .hero { padding: 48px 48px; }
            .form-panel { padding: 48px 40px; }
        }

        /* Tablet portrait: stack vertically */
        @media (max-width: 768px) {
            body {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
                min-height: 100vh;
                overflow-y: auto;
            }

            .hero {
                padding: 40px 28px 36px;
                align-items: center;
                text-align: center;
            }

            .hero-brand { justify-content: center; margin-bottom: 28px; }

            .hero-title { font-size: 24px; letter-spacing: -0.5px; }
            .hero-subtitle { font-size: 13px; margin-bottom: 0; max-width: 100%; }

            .feature-list { display: none; }

            .form-panel {
                padding: 40px 28px 48px;
            }

            .form-panel::before { height: 3px; }
        }

        /* Phone */
        @media (max-width: 480px) {
            .hero { padding: 32px 20px 28px; }
            .hero-title { font-size: 21px; }
            .hero-brand-name { font-size: 17px; }

            .form-panel { padding: 32px 20px 44px; }
            .form-title { font-size: 22px; }

            .btn-submit { padding: 14px; font-size: 14px; }
        }

        /* Very small phones */
        @media (max-width: 360px) {
            .hero { padding: 24px 16px 20px; }
            .form-panel { padding: 28px 16px 40px; }
        }
    </style>
</head>
<body>

<!-- ══════ HERO PANEL ══════ -->
<div class="hero">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="hero-content">
        <div class="hero-brand">
            <div class="hero-brand-icon">
                <i class="fa-solid fa-egg"></i>
            </div>
            <div class="hero-brand-name">
                Inkubator Pintar
                <small>Sistem Pemantauan Telur</small>
            </div>
        </div>

        <h1 class="hero-title">
            Selamat Datang<br>
            <span>Kembali! 👋</span>
        </h1>
        <p class="hero-subtitle">
            Masuk untuk memantau suhu, kelembapan, dan status perangkat inkubator Anda secara real-time dari mana saja.
        </p>

        <div class="feature-list">
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(251,191,36,0.12);">
                    <i class="fa-solid fa-temperature-three-quarters" style="color:#fbbf24;"></i>
                </div>
                <div class="feature-text">
                    <h6>Monitoring Real-time</h6>
                    <p>Pantau suhu & kelembapan inkubator langsung dari browser</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(52,211,153,0.12);">
                    <i class="fa-solid fa-chart-area" style="color:#34d399;"></i>
                </div>
                <div class="feature-text">
                    <h6>Grafik Interaktif</h6>
                    <p>Visualisasi tren data sensor 100 data terakhir</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(167,139,250,0.12);">
                    <i class="fa-solid fa-robot" style="color:#a78bfa;"></i>
                </div>
                <div class="feature-text">
                    <h6>Kontrol Otomatis</h6>
                    <p>Heater, kipas & motor dikendalikan sistem secara cerdas</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(103,232,249,0.12);">
                    <i class="fa-solid fa-clock-rotate-left" style="color:#67e8f9;"></i>
                </div>
                <div class="feature-text">
                    <h6>Riwayat Lengkap</h6>
                    <p>Akses histori data sensor kapan saja</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ══════ FORM PANEL ══════ -->
<div class="form-panel">

    <div class="form-badge">
        <i class="fa-solid fa-lock"></i> Login Akun
    </div>
    <h2 class="form-title">Masuk ke Dashboard</h2>
    <p class="form-subtitle">Gunakan email dan kata sandi yang telah Anda daftarkan.</p>

    @if(session('error'))
        <div class="alert-box danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-box success">
            <i class="fa-solid fa-circle-check"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form method="POST" action="/login" id="loginForm">
        @csrf

        <div class="field">
            <label class="field-label" for="email">Alamat Email</label>
            <div class="field-wrap">
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="field-input @error('email') invalid @enderror"
                    placeholder="contoh@email.com"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required>
                <i class="fa-solid fa-envelope field-icon"></i>
            </div>
            @error('email')
                <div class="error-msg">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="field" style="margin-bottom:28px;">
            <label class="field-label" for="password">Kata Sandi</label>
            <div class="field-wrap">
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="field-input"
                    placeholder="Masukkan kata sandi"
                    autocomplete="current-password"
                    required>
                <i class="fa-solid fa-lock field-icon"></i>
                <button type="button" class="eye-btn" id="togglePwd" aria-label="Tampilkan kata sandi">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit" id="loginBtn">
            <i class="fa-solid fa-right-to-bracket"></i>
            Masuk Sekarang
        </button>
    </form>

    <div class="or-divider">atau</div>

    <div class="bottom-link">
        Belum punya akun? <a href="/register">Daftar gratis</a>
    </div>

    <div class="security-note">
        <i class="fa-solid fa-shield-halved"></i>
        Koneksi aman & terenkripsi — data Anda terlindungi
    </div>
</div>

<script>
    // Toggle password visibility
    const togglePwd = document.getElementById('togglePwd');
    const pwdInput  = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');

    togglePwd.addEventListener('click', () => {
        const isHidden = pwdInput.type === 'password';
        pwdInput.type  = isHidden ? 'text' : 'password';
        eyeIcon.className = isHidden ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    });

    // Loading state on submit
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        btn.disabled = true;
    });
</script>

</body>
</html>