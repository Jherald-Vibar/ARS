<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register — {{ config('app.name') }}</title>
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

    /* ── LEFT IMAGE PANEL ── */
    .left-panel {
      display: none;
      flex: 1;
      background: var(--navy);
      position: relative;
      overflow: hidden;
    }
    @media (min-width: 900px) { .left-panel { display: block; } }

    .left-panel-bg {
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 70% 60% at 20% 30%, rgba(30,64,175,0.55) 0%, transparent 60%),
        radial-gradient(ellipse 50% 50% at 80% 75%, rgba(59,130,246,0.18) 0%, transparent 60%),
        var(--navy);
    }
    .left-panel-grid {
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 56px 56px;
    }
    .left-panel img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.18;
      mix-blend-mode: luminosity;
    }
    .left-panel-content {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: flex-end;
      padding: 3rem;
      z-index: 2;
    }
    .left-panel-content .brand {
      position: absolute;
      top: 2.5rem; left: 3rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-family: var(--font-display);
      font-weight: 800;
      font-size: 1.2rem;
      color: var(--white);
      text-decoration: none;
    }
    .brand-dot { width: 9px; height: 9px; background: var(--yellow-deep); border-radius: 50%; }
    .left-panel-content .tagline {
      font-family: var(--font-display);
      font-size: clamp(1.75rem, 3vw, 2.75rem);
      font-weight: 800;
      color: var(--white);
      line-height: 1.15;
      letter-spacing: -0.02em;
      margin-bottom: 0.75rem;
    }
    .left-panel-content .tagline em { font-style: normal; color: var(--yellow); }
    .left-panel-content p {
      font-size: 0.9rem;
      color: rgba(255,255,255,0.5);
      font-weight: 300;
      line-height: 1.7;
      max-width: 300px;
    }
    .steps {
      display: flex;
      gap: 0.4rem;
      margin-top: 2rem;
    }
    .step { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.25); }
    .step.active { background: var(--yellow); width: 20px; border-radius: 3px; }

    /* ── RIGHT FORM PANEL ── */
    .right-panel {
      width: 100%;
      max-width: 560px;
      background: var(--white);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 2.5rem 3rem;
      overflow-y: auto;
      box-shadow: -4px 0 40px rgba(0,0,83,0.06);
    }

    .mobile-brand {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-family: var(--font-display);
      font-weight: 800;
      font-size: 1.1rem;
      color: var(--navy);
      text-decoration: none;
      margin-bottom: 2.5rem;
    }
    @media (min-width: 900px) { .mobile-brand { display: none; } }

    .reg-badge {
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
      margin-bottom: 0.85rem;
    }
    h1 {
      font-family: var(--font-display);
      font-size: 2.25rem;
      font-weight: 800;
      color: var(--navy);
      line-height: 1.1;
      letter-spacing: -0.02em;
      margin-bottom: 0.4rem;
    }
    .subtitle {
      font-size: 0.875rem;
      color: var(--gray-400);
      font-weight: 300;
      margin-bottom: 2rem;
      line-height: 1.6;
    }

    /* form */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem;
      margin-bottom: 0.85rem;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.28rem;
      margin-bottom: 0.85rem;
    }
    .form-group.no-mb { margin-bottom: 0; }
    .form-group label {
      font-size: 0.7rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--gray-600);
    }
    .form-group input, .form-row-inner input {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1.5px solid var(--gray-200);
      border-radius: 10px;
      font-family: var(--font-body);
      font-size: 0.875rem;
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

    .section-divider {
      font-size: 0.68rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--gray-400);
      margin: 1.25rem 0 0.85rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .section-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--gray-200);
    }

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
      margin-top: 1.25rem;
      margin-bottom: 1rem;
    }
    .btn-primary:hover { background: var(--navy-mid); transform: translateY(-1px); }

    .login-link {
      text-align: center;
      font-size: 0.82rem;
      color: var(--gray-400);
    }
    .login-link a {
      color: var(--sky);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }
    .login-link a:hover { color: var(--navy); }

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
    <div class="left-panel-bg"></div>
    <div class="left-panel-grid"></div>
    <img src="{{ asset('web_images/Rectangle 44.png') }}" alt="">
    <div class="left-panel-content">
      <a href="{{ url('/') }}" class="brand"><span class="brand-dot"></span> Voyair</a>
      <div>
        <p class="tagline">Your journey<br>starts <em>here</em></p>
        <p>Sign up and unlock access to hundreds of routes, real-time tracking, and seamless booking.</p>
        <div class="steps">
          <div class="step active"></div>
          <div class="step"></div>
          <div class="step"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="right-panel">
    <a href="{{ url('/') }}" class="mobile-brand"><span class="brand-dot" style="width:9px;height:9px;background:#f59e0b;border-radius:50%;display:inline-block;"></span> Voyair</a>

    @if ($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="reg-badge">✦ New passenger</div>
    <h1>Create account</h1>
    <p class="subtitle">Sign up to start booking your flights with Voyair.</p>

    <form action="{{ route('passenger-store') }}" method="POST">
      @csrf

      <div class="section-divider">Personal info</div>

      <div class="form-row">
        <div class="form-group no-mb">
          <label>Full Name</label>
          <input name="name" type="text" placeholder="Juan dela Cruz" value="{{ old('name') }}" required />
        </div>
        <div class="form-group no-mb">
          <label>Date of Birth</label>
          <input name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" required />
        </div>
      </div>

      <div class="form-group" style="margin-top:0.85rem;">
        <label>Address</label>
        <input name="address" type="text" placeholder="123 Rizal St, Manila" value="{{ old('address') }}" />
      </div>

      <div class="form-row">
        <div class="form-group no-mb">
          <label>Contact Number</label>
          <input name="contact_number" type="text" placeholder="+63 9XX XXX XXXX" value="{{ old('contact_number') }}" />
        </div>
        <div class="form-group no-mb">
          <label>Passport Number</label>
          <input name="passport_number" type="text" placeholder="P1234567A" value="{{ old('passport_number') }}" />
        </div>
      </div>

      <div class="section-divider">Account credentials</div>

      <div class="form-group">
        <label>Email</label>
        <input name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}" required />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" placeholder="••••••••" required />
      </div>

      <button type="submit" class="btn-primary">Create account →</button>

      <p class="login-link">Already have an account? <a href="{{ route('loginForm') }}">Sign in here</a></p>
    </form>
  </div>

</body>
</html>
