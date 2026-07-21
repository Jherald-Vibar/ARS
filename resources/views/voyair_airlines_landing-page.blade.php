<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyair — Book Your Next Adventure</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy: #000053;
            --navy-mid: #0a0a7a;
            --navy-light: #1a1aa0;
            --blue-accent: #1e40af;
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

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background: var(--white);
            color: var(--gray-800);
            overflow-x: hidden;
        }

        /* ─── NAVBAR ─── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 1.25rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: transparent;
            transition: background 0.4s, backdrop-filter 0.4s, box-shadow 0.4s;
        }
        nav.scrolled {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(16px);
            box-shadow: 0 1px 0 rgba(0,0,83,0.08);
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--white);
            text-decoration: none;
            transition: color 0.4s;
        }
        nav.scrolled .nav-logo { color: var(--navy); }
        .nav-logo .logo-dot {
            width: 10px; height: 10px;
            background: var(--yellow);
            border-radius: 50%;
            display: inline-block;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }
        .nav-links a {
            font-size: 0.875rem;
            font-weight: 500;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: color 0.2s;
        }
        nav.scrolled .nav-links a { color: var(--gray-600); }
        .nav-links a:hover { color: var(--yellow); }
        nav.scrolled .nav-links a:hover { color: var(--navy); }
        .nav-cta {
            background: var(--yellow);
            color: var(--navy) !important;
            font-weight: 700 !important;
            padding: 0.5rem 1.25rem;
            border-radius: 100px;
            transition: background 0.2s, transform 0.2s !important;
        }
        .nav-cta:hover {
            background: var(--yellow-deep) !important;
            transform: translateY(-1px);
            color: var(--navy) !important;
        }

        /* ─── HERO ─── */
        .hero {
            position: relative;
            height: 100vh;
            min-height: 640px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: var(--navy);
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% 0%, rgba(30,64,175,0.5) 0%, transparent 70%),
                radial-gradient(ellipse 60% 40% at 80% 80%, rgba(59,130,246,0.15) 0%, transparent 60%),
                var(--navy);
        }
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 0 1.5rem;
            max-width: 860px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(253,224,71,0.12);
            border: 1px solid rgba(253,224,71,0.3);
            color: var(--yellow);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.375rem 1rem;
            border-radius: 100px;
            margin-bottom: 1.5rem;
        }
        .hero-badge span { opacity: 0.6; }
        h1.hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.5rem, 7vw, 5.5rem);
            font-weight: 800;
            line-height: 1.05;
            color: var(--white);
            margin-bottom: 1.25rem;
            letter-spacing: -0.02em;
        }
        h1.hero-title em {
            font-style: normal;
            color: var(--yellow);
        }
        .hero-subtitle {
            font-size: 1.125rem;
            font-weight: 300;
            color: rgba(255,255,255,0.6);
            max-width: 520px;
            margin: 0 auto 3rem;
            line-height: 1.7;
        }
        .hero-scroll {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            color: rgba(255,255,255,0.4);
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            animation: bounce 2s ease-in-out infinite;
        }
        .hero-scroll-line {
            width: 1px; height: 40px;
            background: linear-gradient(to bottom, rgba(255,255,255,0.4), transparent);
        }
        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(6px); }
        }

        /* ─── SEARCH WIDGET ─── */
        .search-wrapper {
            position: relative;
            z-index: 10;
            margin-top: -4rem;
            padding: 0 1.5rem 3rem;
        }
        .search-card {
            max-width: 860px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 24px 80px rgba(0,0,83,0.18), 0 4px 16px rgba(0,0,83,0.08);
        }
        .search-tabs {
            display: flex;
            gap: 0.25rem;
            margin-bottom: 1.5rem;
        }
        .search-tab {
            padding: 0.4rem 1rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            background: transparent;
            color: var(--gray-400);
            transition: all 0.2s;
        }
        .search-tab.active {
            background: var(--navy);
            color: var(--white);
        }
        .search-form {
            display: grid;
            grid-template-columns: 1fr auto 1fr 1fr auto;
            gap: 0.75rem;
            align-items: center;
        }
        .search-input-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .search-input-group label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--gray-400);
            padding-left: 0.25rem;
        }
        .search-input-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--gray-800);
            background: var(--gray-50);
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .search-input-group input:focus {
            border-color: var(--navy);
            background: var(--white);
        }
        .search-input-group input::placeholder { color: var(--gray-400); font-weight: 400; }
        .swap-btn {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1.5px solid var(--gray-200);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
            margin-top: 1.25rem;
        }
        .swap-btn:hover { background: var(--navy); border-color: var(--navy); }
        .swap-btn:hover svg { stroke: var(--white); }
        .swap-btn svg { stroke: var(--gray-600); transition: stroke 0.2s; }
        .search-btn {
            padding: 0.75rem 1.75rem;
            background: var(--navy);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            letter-spacing: 0.02em;
            transition: background 0.2s, transform 0.2s;
            white-space: nowrap;
            margin-top: 1.25rem;
        }
        .search-btn:hover { background: var(--navy-mid); transform: translateY(-1px); }

        /* ─── FEATURES ─── */
        .features {
            padding: 4rem 1.5rem;
            max-width: 1100px;
            margin: 0 auto;
        }
        .section-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--sky);
            margin-bottom: 0.75rem;
        }
        .section-title {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 800;
            color: var(--navy);
            line-height: 1.15;
            margin-bottom: 0.5rem;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-top: 2.5rem;
        }
        .feature-card {
            background: var(--white);
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            padding: 1.75rem;
            transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
            cursor: pointer;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,83,0.1);
            border-color: rgba(0,0,83,0.2);
        }
        .feature-icon {
            width: 48px; height: 48px;
            background: rgba(0,0,83,0.06);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }
        .feature-icon svg { stroke: var(--navy); }
        .feature-card h3 {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }
        .feature-card p {
            font-size: 0.875rem;
            line-height: 1.7;
            color: var(--gray-600);
            margin-bottom: 1.25rem;
        }
        .feature-link {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--sky);
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: gap 0.2s;
        }
        .feature-link:hover { gap: 0.6rem; }
        .feature-link svg { stroke: var(--sky); }

        /* ─── PROMO BAND ─── */
        .promo-band {
            margin: 2rem 1.5rem;
            border-radius: 24px;
            background: var(--navy);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 360px;
            position: relative;
        }
        .promo-band::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(30,64,175,0.4);
            pointer-events: none;
        }
        .promo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7) saturate(0.8);
        }
        .promo-content {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .promo-tag {
            display: inline-flex;
            align-items: center;
            background: rgba(253,224,71,0.15);
            border: 1px solid rgba(253,224,71,0.35);
            color: var(--yellow);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 0.35rem 0.85rem;
            border-radius: 100px;
            width: fit-content;
            margin-bottom: 1.5rem;
        }
        .promo-content h2 {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 1rem;
        }
        .promo-content p {
            font-size: 0.9rem;
            line-height: 1.7;
            color: rgba(255,255,255,0.6);
            max-width: 340px;
        }

        /* ─── UPCOMING FLIGHTS ─── */
        .flights-section {
            padding: 4rem 1.5rem;
        }
        .flights-header {
            max-width: 1100px;
            margin: 0 auto 2.5rem;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
        }
        .flights-header-text .section-label { margin-bottom: 0.4rem; }
        .see-all-link {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            white-space: nowrap;
            transition: gap 0.2s;
        }
        .see-all-link:hover { gap: 0.55rem; }
        .see-all-link svg { stroke: var(--navy); }
        .flights-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1rem;
        }
        .flight-card {
            background: var(--white);
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            align-items: stretch;
            transition: transform 0.25s, box-shadow 0.25s;
            cursor: pointer;
        }
        .flight-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 36px rgba(0,0,83,0.1);
        }
        .flight-card-img {
            width: 100px;
            flex-shrink: 0;
            overflow: hidden;
        }
        .flight-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(0.85);
            transition: filter 0.3s, transform 0.4s;
        }
        .flight-card:hover .flight-card-img img {
            filter: saturate(1);
            transform: scale(1.05);
        }
        .flight-card-body {
            padding: 1.1rem 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
        }
        .flight-route {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.5rem;
        }
        .flight-route-from,
        .flight-route-to {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--navy);
        }
        .flight-route-arrow svg { stroke: var(--gray-400); }
        .flight-card-body p {
            font-size: 0.78rem;
            color: var(--gray-400);
            line-height: 1.5;
        }
        .flight-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.75rem;
        }
        .flight-time {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--navy);
            background: rgba(0,0,83,0.06);
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
        }
        .flight-badge {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--sky);
        }

        /* ─── PLANE ANIMATION ─── */
        .plane-section {
            overflow: hidden;
            padding: 2rem 0;
            position: relative;
        }
        .plane-track {
            display: flex;
            align-items: center;
        }
        .plane-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gray-200), var(--gray-200), transparent);
        }
        .plane-img {
            width: 180px;
            animation: fly 10s ease-in-out infinite;
            filter: drop-shadow(0 8px 20px rgba(0,0,83,0.15));
        }
        @keyframes fly {
            0% { transform: translateX(-120vw) rotate(2deg); }
            100% { transform: translateX(120vw) rotate(-1deg); }
        }

        /* ─── TESTIMONIALS ─── */
        .testimonials {
            padding: 4rem 1.5rem 5rem;
            background: var(--gray-50);
        }
        .testimonials-inner {
            max-width: 1100px;
            margin: 0 auto;
        }
        .testimonials-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }
        .testimonial-card {
            background: var(--white);
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            padding: 1.75rem;
            position: relative;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .testimonial-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,83,0.08);
        }
        .testimonial-quote-mark {
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 800;
            line-height: 1;
            color: var(--yellow);
            margin-bottom: 0.5rem;
        }
        .testimonial-card p {
            font-size: 0.9rem;
            font-style: italic;
            line-height: 1.75;
            color: var(--gray-600);
            margin-bottom: 1.25rem;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .author-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--yellow);
            flex-shrink: 0;
        }
        .author-info p:first-child {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-800);
            font-style: normal;
            margin-bottom: 0;
        }
        .author-info p:last-child {
            font-size: 0.75rem;
            color: var(--gray-400);
            font-style: normal;
        }
        .stars {
            display: flex;
            gap: 2px;
            margin-bottom: 0.75rem;
        }
        .star { color: var(--yellow-deep); font-size: 0.9rem; }

        /* ─── FOOTER ─── */
        footer {
            background: var(--navy);
            color: rgba(255,255,255,0.65);
            padding: 3rem 1.5rem 2rem;
        }
        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
        }
        .footer-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 1.5rem;
        }
        .footer-brand { max-width: 280px; }
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--white);
            margin-bottom: 0.75rem;
        }
        .footer-brand p {
            font-size: 0.8rem;
            line-height: 1.6;
        }
        .footer-links-group h4 {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--white);
            margin-bottom: 1rem;
        }
        .footer-links-group ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        .footer-links-group a {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-links-group a:hover { color: var(--yellow); }
        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-bottom p { font-size: 0.8rem; }
        .footer-bottom a { color: rgba(255,255,255,0.55); text-decoration: none; }
        .footer-bottom a:hover { color: var(--yellow); }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .search-form { grid-template-columns: 1fr 1fr; }
            .swap-btn { display: none; }
            .search-btn { grid-column: 1 / -1; margin-top: 0; }
            .promo-band { grid-template-columns: 1fr; }
            .promo-band .promo-img-wrap { height: 200px; }
            .flights-header { flex-direction: column; align-items: flex-start; }
            .nav-links { display: none; }
            nav { padding: 1rem 1.25rem; }
        }
    </style>
</head>
<body>

<!-- ─── NAVBAR ─── -->
<nav id="navbar">
    <a href="#" class="nav-logo">
        <span class="logo-dot"></span> Voyair
    </a>
    <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">Flights</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="{{route('loginForm')}}" class="nav-cta">Login</a></li>
    </ul>
</nav>

<!-- ─── HERO ─── -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span>✦</span> The smarter way to fly
        </div>
        <h1 class="hero-title">
            Fly to your<br>
            <em>next adventure</em>
        </h1>
        <p class="hero-subtitle">
            Discover thousands of routes worldwide. Book fast, fly smart, arrive happy.
        </p>
    </div>
    <div class="hero-scroll">
        <div class="hero-scroll-line"></div>
        scroll
    </div>
</section>

<!-- ─── SEARCH ─── -->
<div class="search-wrapper">
    <div class="search-card">
        <div class="search-tabs">
            <button class="search-tab active">One Way</button>
            <button class="search-tab">Round Trip</button>
            <button class="search-tab">Multi-city</button>
        </div>
        <div class="search-form">
            <div class="search-input-group">
                <label>From</label>
                <input type="text" placeholder="City or airport" />
            </div>
            <button class="swap-btn" title="Swap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7 16V4m0 0L4 7m3-3l3 3M17 8v12m0 0l3-3m-3 3l-3-3"/>
                </svg>
            </button>
            <div class="search-input-group">
                <label>To</label>
                <input type="text" placeholder="City or airport" />
            </div>
            <div class="search-input-group">
                <label>Departing</label>
                <input type="date" />
            </div>
            <button class="search-btn">Search Flights →</button>
        </div>
    </div>
</div>

<!-- ─── FEATURES ─── -->
<section class="features">
    <div class="section-label">Why Voyair</div>
    <h2 class="section-title">Everything you need<br>in one place</h2>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <h3>Need help with a claim?</h3>
            <p>Our step-by-step guide walks you through every part of the claims process — no confusion, no hassle.</p>
            <a href="#" class="feature-link">
                See our guideline
                <svg width="13" height="13" viewBox="0 0 18 18" fill="none" stroke-width="2"><path d="M5 9h8M11 5l4 4-4 4"/></svg>
            </a>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <h3>Real-time flight tracking</h3>
            <p>Stay updated with live departure, arrival, and gate information right at your fingertips.</p>
            <a href="#" class="feature-link">
                Learn more
                <svg width="13" height="13" viewBox="0 0 18 18" fill="none" stroke-width="2"><path d="M5 9h8M11 5l4 4-4 4"/></svg>
            </a>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </div>
            <h3>Passenger-first experience</h3>
            <p>From booking to boarding, we've designed every touchpoint around what matters most — you.</p>
            <a href="#" class="feature-link">
                Our story
                <svg width="13" height="13" viewBox="0 0 18 18" fill="none" stroke-width="2"><path d="M5 9h8M11 5l4 4-4 4"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- ─── PROMO BAND ─── -->
<div style="padding: 0 1.5rem 4rem; max-width: 1100px; margin: 0 auto;">
    <div class="promo-band">
        <div class="promo-img-wrap" style="overflow:hidden;">
            <img class="promo-img" src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800&q=80" alt="Airplane in flight">
        </div>
        <div class="promo-content">
            <div class="promo-tag">✈ Featured experience</div>
            <h2>The sky is not the limit — it's just the beginning</h2>
            <p>Premium routes, real-time support, and seamless booking across 180+ destinations worldwide.</p>
        </div>
    </div>
</div>

<!-- ─── UPCOMING FLIGHTS ─── -->
<section class="flights-section">
    <div class="flights-header">
        <div class="flights-header-text">
            <div class="section-label">Departing soon</div>
            <h2 class="section-title">Upcoming Flights</h2>
        </div>
        <a href="#" class="see-all-link">
            See all flights
            <svg width="14" height="14" viewBox="0 0 18 18" fill="none" stroke-width="2.5"><path d="M5 9h8M11 5l4 4-4 4"/></svg>
        </a>
    </div>

    <div class="flights-grid">

        @foreach ( $flights as $flight )
        <div class="flight-card">
            <div class="flight-card-img"><img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=200&q=70" alt="Tokyo" loading="lazy"></div>
            <div class="flight-card-body">
                <div>
                    <div class="flight-route">
                        <span class="flight-route-from">{{$flight->arrivalAirport->city}}</span>
                        <span class="flight-route-arrow"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
                        <span class="flight-route-to">{{$flight->departureAirport->city}}</span>
                    </div>
                    <p>Flight to {{$flight->arrivalAirport->country}}<br>{{$flight->arrival_date}}</p>
                </div>
                <div class="flight-meta"><span class="flight-time">{{$flight->departure_time}}</span><span class="flight-badge">{{$flight->status}}</span></div>
            </div>
        </div>
        @endforeach

    </div>
</section>

<!-- ─── PLANE ANIMATION ─── -->
<div class="plane-section">
    <div class="plane-track">
        <div class="plane-line"></div>
        <svg class="plane-img" viewBox="0 0 200 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 40 L160 20 L190 30 L160 40 L10 40Z" fill="#000053" opacity="0.9"/>
            <path d="M50 40 L80 55 L90 40" fill="#1e40af"/>
            <path d="M30 40 L50 50 L55 40" fill="#1e40af"/>
            <path d="M160 30 L175 35 L165 40" fill="#fde047"/>
            <circle cx="175" cy="30" r="4" fill="#fde047"/>
        </svg>
        <div class="plane-line"></div>
    </div>
</div>

<!-- ─── TESTIMONIALS ─── -->
<section class="testimonials">
    <div class="testimonials-inner">
        <div class="testimonials-header">
            <div class="section-label" style="text-align:center;">Passenger reviews</div>
            <h2 class="section-title" style="text-align:center;">Our happy passengers</h2>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                </div>
                <div class="testimonial-quote-mark">"</div>
                <p>Amazing service! The trip was comfortable and on time. I've never had such a smooth experience booking a flight.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">JD</div>
                    <div class="author-info">
                        <p>John D.</p>
                        <p>Frequent flyer · Manila</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                </div>
                <div class="testimonial-quote-mark">"</div>
                <p>Friendly staff and excellent support throughout the journey. They handled every concern promptly and professionally.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">SW</div>
                    <div class="author-info">
                        <p>Sarah W.</p>
                        <p>Business traveller · Cebu</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                </div>
                <div class="testimonial-quote-mark">"</div>
                <p>Clean, comfortable, and great value for the price. Voyair has completely changed how I think about travel.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">MB</div>
                    <div class="author-info">
                        <p>Michael B.</p>
                        <p>First-time flyer · Davao</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ─── FOOTER ─── -->
<footer>
    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-brand">
                <div class="footer-logo">
                    <span style="width:10px;height:10px;background:#fde047;border-radius:50%;display:inline-block;"></span>
                    Voyair
                </div>
                <p>Your trusted partner in air travel. Connecting people to the places they love, one flight at a time.</p>
            </div>
            <div class="footer-links-group">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="footer-links-group">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Claim help</a></li>
                    <li><a href="#">Flight status</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-links-group">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy policy</a></li>
                    <li><a href="#">Terms of service</a></li>
                    <li><a href="#">Licensing</a></li>
                    <li><a href="#">Cookies</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Voyair. All rights reserved.</p>
            <p>Designed with care for every passenger.</p>
        </div>
    </div>
</footer>

<script>
    const nav = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 60);
    });

    document.querySelectorAll('.search-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.search-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

    document.querySelector('.swap-btn')?.addEventListener('click', () => {
        const inputs = document.querySelectorAll('.search-input-group input[type="text"]');
        const temp = inputs[0].value;
        inputs[0].value = inputs[1].value;
        inputs[1].value = temp;
    });
</script>
</body>
</html>
