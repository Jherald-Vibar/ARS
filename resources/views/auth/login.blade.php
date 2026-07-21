<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login — {{ config('app.name') }}</title>
  <link rel="icon" href="{{ asset('web_images/image 1.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy: #000053;
      --navy-mid: #0a0a7a;
      --sky: #3b82f6;
      --yellow: #fde047;
      --yellow-deep: #f59e0b;
      --white: #ffffff;
      --gray-50: #f8fafc;
      --gray-100: #f1f5f9;
      --gray-200: #e2e8f0;
      --gray-400: #94a3b8;
      --gray-600: #475569;
      --gray-800: #1e293b;
      --font-display: 'Syne', sans-serif;
      --font-body: 'DM Sans', sans-serif;
    }
    body {
      font-family: var(--font-body);
      background: var(--gray-50);
      min-height: 100vh;
      display: flex;
      align-items: stretch;
    }

    /* ── LEFT PANEL ── */
    .left-panel {
      width: 100%;
      max-width: 480px;
      background: var(--white);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 2.5rem 3rem;
      position: relative;
      z-index: 1;
      box-shadow: 4px 0 40px rgba(0,0,83,0.07);
    }
    .panel-top { display: flex; flex-direction: column; gap: 0; }

    .brand {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-family: var(--font-display);
      font-weight: 800;
      font-size: 1.2rem;
      color: var(--navy);
      text-decoration: none;
      margin-bottom: 3.5rem;
    }
    .brand-dot {
      width: 9px; height: 9px;
      background: var(--yellow-deep);
      border-radius: 50%;
    }

    .login-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      background: rgba(0,0,83,0.05);
      border: 1px solid rgba(0,0,83,0.1);
      color: var(--navy);
      font-size: 0.68rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 0.3rem 0.85rem;
      border-radius: 100px;
      width: fit-content;
      margin-bottom: 1rem;
    }

    h1 {
      font-family: var(--font-display);
      font-size: 2.75rem;
      font-weight: 800;
      color: var(--navy);
      line-height: 1.1;
      letter-spacing: -0.02em;
      margin-bottom: 0.5rem;
    }
    .subtitle {
      font-size: 0.9rem;
      color: var(--gray-400);
      font-weight: 300;
      margin-bottom: 2.5rem;
      line-height: 1.6;
    }

    /* ── FORM ── */
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.3rem;
      margin-bottom: 1.1rem;
    }
    .form-group label {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--gray-600);
    }
    .form-group input {
      width: 100%;
      padding: 0.8rem 1rem;
      border: 1.5px solid var(--gray-200);
      border-radius: 10px;
      font-family: var(--font-body);
      font-size: 0.9rem;
      color: var(--gray-800);
      background: var(--gray-50);
      outline: none;
      transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    .form-group input:focus {
      border-color: var(--navy);
      background: var(--white);
      box-shadow: 0 0 0 3px rgba(0,0,83,0.07);
    }
    .form-group input::placeholder { color: var(--gray-400); font-weight: 300; }

    .forgot {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 1.75rem;
    }
    .forgot a {
      font-size: 0.78rem;
      color: var(--sky);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }
    .forgot a:hover { color: var(--navy); }

    .btn-primary {
      width: 100%;
      padding: 0.85rem;
      background: var(--navy);
      color: var(--white);
      border: none;
      border-radius: 10px;
      font-family: var(--font-display);
      font-weight: 700;
      font-size: 0.9rem;
      letter-spacing: 0.02em;
      cursor: pointer;
      transition: background 0.2s, transform 0.15s;
      margin-bottom: 0.75rem;
    }
    .btn-primary:hover { background: var(--navy-mid); transform: translateY(-1px); }
    .btn-primary:active { transform: translateY(0); }

    .divider {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 0.75rem;
    }
    .divider-line { flex: 1; height: 1px; background: var(--gray-200); }
    .divider span { font-size: 0.72rem; color: var(--gray-400); }

    .btn-secondary {
      width: 100%;
      padding: 0.85rem;
      background: transparent;
      color: var(--navy);
      border: 1.5px solid var(--gray-200);
      border-radius: 10px;
      font-family: var(--font-display);
      font-weight: 700;
      font-size: 0.9rem;
      letter-spacing: 0.02em;
      cursor: pointer;
      transition: border-color 0.2s, background 0.2s, transform 0.15s;
    }
    .btn-secondary:hover {
      border-color: var(--navy);
      background: rgba(0,0,83,0.03);
      transform: translateY(-1px);
    }

    .panel-footer {
      font-size: 0.75rem;
      color: var(--gray-400);
      text-align: center;
    }

    /* ── RIGHT PANEL ── */
    .right-panel {
      flex: 1;
      background: var(--navy);
      position: relative;
      overflow: hidden;
      display: none;
    }
    @media (min-width: 768px) { .right-panel { display: block; } }

    .right-panel-bg {
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 80% 60% at 30% 20%, rgba(30,64,175,0.6) 0%, transparent 60%),
        radial-gradient(ellipse 50% 50% at 80% 80%, rgba(59,130,246,0.2) 0%, transparent 60%),
        var(--navy);
    }
    .right-panel-grid {
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 56px 56px;
    }
    .right-panel img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.18;
      mix-blend-mode: luminosity;
    }
    .right-panel-content {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 3rem;
      text-align: center;
      z-index: 2;
    }
    .right-panel-content .tagline {
      font-family: var(--font-display);
      font-size: clamp(2rem, 4vw, 3.5rem);
      font-weight: 800;
      color: var(--white);
      line-height: 1.1;
      letter-spacing: -0.02em;
      margin-bottom: 1.25rem;
    }
    .right-panel-content .tagline em {
      font-style: normal;
      color: var(--yellow);
    }
    .right-panel-content p {
      font-size: 1rem;
      color: rgba(255,255,255,0.55);
      font-weight: 300;
      max-width: 340px;
      line-height: 1.7;
    }
    .right-panel-dots {
      position: absolute;
      bottom: 2.5rem;
      display: flex;
      gap: 0.4rem;
    }
    .dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.25); }
    .dot.active { background: var(--yellow); width: 20px; border-radius: 3px; }

    /* error */
    .alert-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #b91c1c;
      border-radius: 10px;
      padding: 0.75rem 1rem;
      font-size: 0.82rem;
      margin-bottom: 1.25rem;
    }
  </style>
</head>
<body>

  <!-- LEFT PANEL -->
  <div class="left-panel">
    <div class="panel-top">
      <a href="{{ url('/') }}" class="brand">
        <span class="brand-dot"></span> Voyair
      </a>

      @if ($errors->any())
        <div class="alert-error">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="login-badge">✦ Welcome back</div>
      <h1>Sign in</h1>
      <p class="subtitle">Enter your credentials to access your account.</p>

      <form action="{{ route('authenticate') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="••••••••" required />
        </div>
        <div class="forgot">
          <a href="#">Forgot password?</a>
        </div>
        <button type="submit" class="btn-primary">Sign in →</button>
      </form>

      <div class="divider">
        <div class="divider-line"></div>
        <span>or</span>
        <div class="divider-line"></div>
      </div>

      <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('registerForm') }}'">
        Create an account
      </button>
    </div>

    <p class="panel-footer">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
  </div>

  <!-- RIGHT PANEL -->
  <div class="right-panel">
    <div class="right-panel-bg"></div>
    <div class="right-panel-grid"></div>
    <img src="{{ asset('web_images/Ellipse 2.png') }}" alt="">
    <div class="right-panel-content">
      <p class="tagline">Fly to your<br><em>next adventure</em></p>
      <p>Thousands of routes. Real-time tracking. Seamless booking across 180+ destinations.</p>
    </div>
    <div class="right-panel-dots">
      <div class="dot active"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </div>

</body>
</html>
