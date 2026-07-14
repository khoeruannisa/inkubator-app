<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Inkubator Telur Pintar</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px 16px;
            background: #08091a;
            position: relative;
            overflow-y: auto;
        }

        /* ── BACKGROUND ── */
        .bg-mesh {
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 65% 55% at 12% 12%, rgba(124,58,237,.32) 0%, transparent 60%),
                radial-gradient(ellipse 55% 50% at 88% 82%, rgba(236,72,153,.22) 0%, transparent 55%),
                radial-gradient(ellipse 45% 40% at 50% 50%, rgba(245,158,11,.1)  0%, transparent 55%),
                radial-gradient(ellipse 55% 50% at 8%  90%, rgba(6,182,212,.16)  0%, transparent 55%),
                linear-gradient(155deg, #08091a 0%, #0f0a24 60%, #0a0d1e 100%);
        }

        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.02) 1px, transparent 1px);
            background-size: 44px 44px;
        }

        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(70px); opacity: .55;
            animation: drift linear infinite; z-index: 0; pointer-events: none;
        }
        .orb-1 { width:460px;height:460px;background:rgba(124,58,237,.28);top:-120px;left:-80px;animation-duration:19s; }
        .orb-2 { width:360px;height:360px;background:rgba(236,72,153,.2);bottom:-80px;right:-60px;animation-duration:23s;animation-delay:-7s; }
        .orb-3 { width:260px;height:260px;background:rgba(245,158,11,.15);top:40%;right:10%;animation-duration:15s;animation-delay:-11s; }

        @keyframes drift {
            0%,100% { transform:translate(0,0) scale(1); }
            33%      { transform:translate(22px,-16px) scale(1.04); }
            66%      { transform:translate(-16px,22px) scale(.96); }
        }

        /* ── CARD ── */
        .card {
            position: relative; z-index: 10;
            width: 100%; max-width: 380px;
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 24px;
            padding: 36px 32px 32px;
            box-shadow: 0 0 0 1px rgba(255,255,255,.04) inset, 0 40px 80px rgba(0,0,0,.58), 0 0 50px rgba(124,58,237,.1);
            animation: cardIn .55s cubic-bezier(.34,1.56,.64,1) both;
        }
        @keyframes cardIn {
            from { opacity:0; transform:translateY(28px) scale(.96); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }
        .card::before {
            content:''; position:absolute;
            top:0; left:44px; right:44px; height:2px;
            background:linear-gradient(90deg,transparent,rgba(139,92,246,.9),rgba(236,72,153,.8),transparent);
        }

        /* ── BRAND ── */
        .brand { display:flex;flex-direction:column;align-items:center;margin-bottom:28px; }
        .brand-icon {
            width:62px;height:62px;
            background:linear-gradient(135deg,#7c3aed,#ec4899);
            border-radius:19px;
            display:flex;align-items:center;justify-content:center;
            font-size:25px;color:#fff;margin-bottom:13px;
            box-shadow:0 0 0 5px rgba(124,58,237,.18),0 12px 28px rgba(124,58,237,.45);
            animation:pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%,100% { box-shadow:0 0 0 5px rgba(124,58,237,.18),0 12px 28px rgba(124,58,237,.45); }
            50%      { box-shadow:0 0 0 9px rgba(124,58,237,.08),0 16px 36px rgba(124,58,237,.55); }
        }
        .brand-name { font-size:21px;font-weight:800;color:#fff;letter-spacing:-.4px;margin-bottom:4px; }
        .brand-sub  { font-size:12.5px;color:rgba(255,255,255,.38);font-weight:500; }

        /* ── FORM HEADING ── */
        .fhead { text-align:center;margin-bottom:24px; }
        .fhead h2 { font-size:18.5px;font-weight:800;color:#f1f5f9;letter-spacing:-.3px;margin-bottom:5px; }
        .fhead p  { font-size:13px;color:rgba(255,255,255,.38); }

        /* ── ALERTS ── */
        .alert {
            display:flex;align-items:flex-start;gap:10px;
            padding:12px 15px;border-radius:12px;
            font-size:13px;font-weight:500;margin-bottom:18px;
            animation:slideDown .3s ease;
        }
        @keyframes slideDown {
            from{opacity:0;transform:translateY(-6px)}
            to{opacity:1;transform:translateY(0)}
        }
        .alert i { flex-shrink:0;margin-top:1px; }
        .alert-danger  { background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.22);color:#fca5a5; }
        .alert-success { background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.22);color:#86efac; }

        /* ── FIELDS ── */
        .field { margin-bottom:15px; }
        .field-label {
            display:block;font-size:11px;font-weight:700;
            color:rgba(255,255,255,.45);text-transform:uppercase;
            letter-spacing:.08em;margin-bottom:8px;
        }
        .field-wrap { position:relative; }
        .field-input {
            width:100%;padding:13px 14px 13px 44px;
            background:rgba(255,255,255,.06);
            border:1.5px solid rgba(255,255,255,.09);
            border-radius:13px;font-size:14px;font-weight:500;
            color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;
            transition:all .22s ease;-webkit-appearance:none;
        }
        .field-input::placeholder { color:rgba(255,255,255,.2); }
        .field-input:focus {
            outline:none;background:rgba(255,255,255,.09);
            border-color:rgba(139,92,246,.75);
            box-shadow:0 0 0 4px rgba(139,92,246,.14);
        }
        .field-input.has-eye { padding-right:44px; }
        .field-input.invalid { border-color:rgba(239,68,68,.55);background:rgba(239,68,68,.07); }
        .field-input.invalid:focus { box-shadow:0 0 0 4px rgba(239,68,68,.12); }

        .field-icon {
            position:absolute;left:14px;top:50%;transform:translateY(-50%);
            font-size:14px;color:rgba(255,255,255,.28);pointer-events:none;transition:color .2s;
        }
        .field-wrap:focus-within .field-icon { color:rgba(139,92,246,.9); }

        .eye-btn {
            position:absolute;right:13px;top:50%;transform:translateY(-50%);
            background:none;border:none;color:rgba(255,255,255,.28);
            cursor:pointer;padding:4px;border-radius:6px;font-size:13.5px;
            transition:color .2s;line-height:1;
        }
        .eye-btn:hover { color:rgba(255,255,255,.65); }

        .error-msg {
            display:flex;align-items:center;gap:5px;
            font-size:11.5px;color:#fca5a5;margin-top:6px;
        }

        /* ── PASSWORD STRENGTH ── */
        .strength-bars {
            display:flex;gap:4px;margin-top:8px;
        }
        .s-bar {
            flex:1;height:3px;border-radius:3px;
            background:rgba(255,255,255,.1);transition:background .35s ease;
        }
        .s-bar.weak   { background:#ef4444; }
        .s-bar.medium { background:#f59e0b; }
        .s-bar.strong { background:#22c55e; }

        .strength-label {
            font-size:11px;color:rgba(255,255,255,.3);margin-top:6px;
            display:flex;align-items:center;gap:5px;
        }

        /* ── BUTTON ── */
        .btn-submit {
            width:100%;padding:14.5px;margin-top:10px;
            background:linear-gradient(135deg,#7c3aed,#6d28d9 55%,#5b21b6);
            border:none;border-radius:13px;
            font-size:14.5px;font-weight:700;color:#fff;
            cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;
            transition:all .28s ease;
            box-shadow:0 6px 22px rgba(124,58,237,.45);
            display:flex;align-items:center;justify-content:center;gap:9px;
            position:relative;overflow:hidden;
        }
        .btn-submit::before {
            content:'';position:absolute;inset:0;
            background:linear-gradient(135deg,rgba(255,255,255,.12),transparent 55%);
        }
        .btn-submit:hover { transform:translateY(-2px);box-shadow:0 12px 30px rgba(124,58,237,.58); }
        .btn-submit:active { transform:translateY(0); }

        /* ── DIVIDER + LINK ── */
        .divider {
            display:flex;align-items:center;gap:12px;
            margin:22px 0;font-size:12px;color:rgba(255,255,255,.18);font-weight:600;
        }
        .divider::before,.divider::after { content:'';flex:1;height:1px;background:rgba(255,255,255,.07); }

        .bottom-link { text-align:center;font-size:13.5px;color:rgba(255,255,255,.38);font-weight:500; }
        .bottom-link a { color:#c084fc;font-weight:700;text-decoration:none;transition:color .2s; }
        .bottom-link a:hover { color:#d8b4fe; }

        .btn-back {
            display:inline-flex;align-items:center;gap:7px;
            padding:9px 18px;border-radius:10px;
            background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);
            color:rgba(255,255,255,.6);font-weight:700;font-size:13px;
            text-decoration:none;transition:all .2s;
        }
        .btn-back:hover { background:rgba(255,255,255,.11);color:rgba(255,255,255,.85); }

        /* ── RESPONSIVE ── */
        @media(max-width:480px) {
            .card { padding:28px 20px 26px;border-radius:20px; }
            .brand-icon { width:50px;height:50px;font-size:20px; }
            .brand-name { font-size:18px; }
        }
        @media(max-width:360px) {
            .card { padding:22px 14px 22px;border-radius:16px; }
        }
    </style>
</head>
<body>

<div class="bg-mesh"></div>
<div class="bg-grid"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="card">
    <div class="brand">
        <div class="brand-icon"><i class="fa-solid fa-egg"></i></div>
        <div class="brand-name">Inkubator Pintar</div>
        <div class="brand-sub">Sistem Pemantauan Telur Otomatis</div>
    </div>

    <div class="fhead">
        <h2>Buat Akun Baru 🥚</h2>
        <p>Daftar dan mulai pantau inkubator Anda dari mana saja</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $errors->first() }}</span></div>
    @endif
    @if(session('success'))
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></div>
    @endif

    <form method="POST" action="/register" id="registerForm">
        @csrf

        <div class="field">
            <label class="field-label" for="name">Nama Lengkap</label>
            <div class="field-wrap">
                <input id="name" type="text" name="name"
                    class="field-input @error('name') invalid @enderror"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('name') }}" autocomplete="name" required>
                <i class="fa-solid fa-user field-icon"></i>
            </div>
            @error('name')
                <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label class="field-label" for="email">Alamat Email</label>
            <div class="field-wrap">
                <input id="email" type="email" name="email"
                    class="field-input @error('email') invalid @enderror"
                    placeholder="contoh@email.com"
                    value="{{ old('email') }}" autocomplete="email" required>
                <i class="fa-solid fa-envelope field-icon"></i>
            </div>
            @error('email')
                <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="field" style="margin-bottom:22px;">
            <label class="field-label" for="password">Kata Sandi</label>
            <div class="field-wrap">
                <input id="password" type="password" name="password"
                    class="field-input has-eye"
                    placeholder="Minimal 4 karakter"
                    autocomplete="new-password" required>
                <i class="fa-solid fa-lock field-icon"></i>
                <button type="button" class="eye-btn" id="togglePwd" aria-label="Tampilkan sandi">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </button>
            </div>
            <div class="strength-bars">
                <div class="s-bar" id="b1"></div>
                <div class="s-bar" id="b2"></div>
                <div class="s-bar" id="b3"></div>
                <div class="s-bar" id="b4"></div>
            </div>
            <div class="strength-label" id="sLabel">
                <i class="fa-solid fa-info-circle"></i>
                <span id="sText">Gunakan kombinasi huruf dan angka</span>
            </div>
        </div>

        <button type="submit" class="btn-submit" id="registerBtn">
            <i class="fa-solid fa-rocket"></i> Buat Akun Sekarang
        </button>
    </form>

    <div class="divider">atau</div>

    <div class="bottom-link">
        @auth
            <a href="/dashboard" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard</a>
        @else
            Sudah punya akun? <a href="/login">Masuk di sini</a>
        @endauth
    </div>
</div>

<script>
    // Toggle password
    const togglePwd = document.getElementById('togglePwd');
    const pwdInput  = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');
    togglePwd.addEventListener('click', () => {
        const show = pwdInput.type === 'password';
        pwdInput.type = show ? 'text' : 'password';
        eyeIcon.className = show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    });

    // Strength meter
    const bars  = ['b1','b2','b3','b4'].map(id => document.getElementById(id));
    const sText = document.getElementById('sText');
    const lbls  = ['Gunakan kombinasi huruf dan angka','Sangat lemah','Lemah','Cukup kuat','Kuat sekali! 💪'];
    const clrs  = ['','weak','weak','medium','strong'];

    pwdInput.addEventListener('input', () => {
        const v = pwdInput.value;
        let score = 0;
        if (v.length >= 4)  score++;
        if (v.length >= 8)  score++;
        if (/[A-Z]/.test(v) || /[0-9]/.test(v)) score++;
        if (/[!@#$%^&*]/.test(v)) score++;

        bars.forEach((b, i) => { b.className = 's-bar ' + (i < score ? clrs[score] : ''); });
        sText.textContent = v.length ? lbls[score] : lbls[0];
    });

    // Loading on submit
    document.getElementById('registerForm').addEventListener('submit', function() {
        const btn = document.getElementById('registerBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        btn.disabled = true;
    });
</script>
</body>
</html>