<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="icon" href="{{ asset('web_images/image 1.png') }}">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        :root {
            --navy: #000053;
            --navy-mid: #0a0a7a;
            --sky: #3b82f6;
            --yellow: #fde047;
            --yellow-deep: #f59e0b;
            --font-display: 'Syne', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }
        body { font-family: var(--font-body); }
        .font-display { font-family: var(--font-display); }

        /* Navbar */
        #navbar {
            transition: background 0.4s, backdrop-filter 0.4s, box-shadow 0.4s;
            background: transparent;
        }
        #navbar.scrolled {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(16px);
            box-shadow: 0 1px 0 rgba(0,0,83,0.08);
        }
        #navbar.scrolled .nav-link { color: #475569; }
        #navbar.scrolled .nav-link:hover { color: var(--navy); }
        #navbar.scrolled .nav-logo { color: var(--navy); }
        #navbar.scrolled .nav-logo .logo-dot { background: var(--yellow-deep); }

        /* Carousel overlay gradient */
        .carousel-overlay {
            background: linear-gradient(to bottom, rgba(0,0,83,0.45) 0%, rgba(0,0,83,0.2) 60%, rgba(0,0,83,0.55) 100%);
        }

        /* Search card */
        .search-card {
            box-shadow: 0 24px 80px rgba(0,0,83,0.18), 0 4px 16px rgba(0,0,83,0.08);
        }

        /* Plane animation */
        @keyframes fly {
            0%   { transform: translateX(-120vw) rotate(2deg); }
            100% { transform: translateX(120vw) rotate(-1deg); }
        }
        .plane-fly { animation: fly 12s linear infinite; }
    </style>
</head>
<body class="bg-white text-gray-800 overflow-x-hidden">

{{-- ─── NAVBAR ─── --}}
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 px-6 md:px-10 py-4 flex items-center justify-between">

    {{-- Logo --}}
    <a href="{{ route('passenger-dashboard') }}" class="nav-logo flex items-center gap-2 font-display font-extrabold text-xl text-white no-underline" style="transition: color 0.4s;">
        <span class="logo-dot inline-block w-2.5 h-2.5 rounded-full" style="background: var(--yellow);"></span>
        {{ config('app.name') }}
    </a>

    {{-- Nav links --}}
    @auth('passenger')
    <ul class="hidden md:flex items-center gap-8 list-none m-0 p-0">
        <li>
            <a href="{{ route('passenger-dashboard') }}"
               class="nav-link text-sm font-medium text-white/85 hover:text-yellow-300 no-underline transition-colors duration-200">
                Home
            </a>
        </li>
        <li>
            <a href="#"
               class="nav-link text-sm font-medium text-white/85 hover:text-yellow-300 no-underline transition-colors duration-200">
                Flights
            </a>
        </li>

        {{-- User dropdown --}}
        <li x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="nav-link flex items-center gap-2 text-sm font-medium text-white/85 hover:text-yellow-300 transition-colors duration-200 focus:outline-none">
                <img src="{{ asset('web_images/image 1.png') }}" alt="Avatar"
                     class="w-7 h-7 rounded-full ring-2 ring-white/30">
                <span>{{ Auth::guard('passenger')->user()->name }}</span>
                <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-transition @click.away="open = false"
                 class="absolute right-0 mt-2 w-44 bg-white border border-gray-100 rounded-xl shadow-xl z-50 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-xs text-gray-400 font-medium">Signed in as</p>
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::guard('passenger')->user()->name }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
    @endauth
</nav>

{{-- ─── HERO CAROUSEL ─── --}}
<div id="default-carousel" class="relative w-full" data-carousel="slide">
    <div class="relative h-[70vh] min-h-[520px] overflow-hidden">

        {{-- Slides --}}
        @foreach (['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'] as $index => $carouselImage)
            <div class="{{ $index === 0 ? 'block' : 'hidden' }} duration-700 ease-in-out absolute inset-0"
                 data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('web_images/'.$carouselImage) }}" alt="Slide {{ $index + 1 }}"
                     class="w-full h-full object-cover">
            </div>
        @endforeach

        {{-- Dark overlay --}}
        <div class="carousel-overlay absolute inset-0 z-10 pointer-events-none"></div>

        {{-- Hero text overlay --}}
        <div class="absolute inset-0 z-20 flex flex-col items-center justify-center text-center px-6 pt-16">
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold tracking-widest uppercase mb-5"
                 style="background: rgba(253,224,71,0.12); border: 1px solid rgba(253,224,71,0.3); color: var(--yellow);">
                <span class="opacity-60">✦</span> The smarter way to fly
            </div>
            <h1 class="font-display font-extrabold text-white leading-tight tracking-tight mb-4"
                style="font-size: clamp(2.2rem, 6vw, 4.5rem);">
                Fly to your<br>
                <em class="not-italic" style="color: var(--yellow);">next adventure</em>
            </h1>
            <p class="text-white/60 font-light max-w-md leading-relaxed" style="font-size: 1.05rem;">
                Discover thousands of routes worldwide. Book fast, fly smart, arrive happy.
            </p>
        </div>

        {{-- Scroll hint --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-1 text-white/40 text-[0.65rem] tracking-widest uppercase"
             style="animation: bounce2 2s ease-in-out infinite;">
            <div class="w-px h-8" style="background: linear-gradient(to bottom, rgba(255,255,255,0.35), transparent);"></div>
            scroll
        </div>

        {{-- Prev / Next buttons --}}
        <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 group"
                data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/20 group-hover:bg-white/40 transition-colors">
                <svg class="w-4 h-4 text-white" viewBox="0 0 6 10" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
            </span>
        </button>
        <button type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 group"
                data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/20 group-hover:bg-white/40 transition-colors">
                <svg class="w-4 h-4 text-white" viewBox="0 0 6 10" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                </svg>
            </span>
        </button>

        {{-- Dot indicators --}}
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-30 flex gap-2">
            @foreach (['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'] as $index => $carouselImage)
                <button type="button"
                        class="w-2 h-2 rounded-full bg-white/50 hover:bg-white transition-colors"
                        aria-label="Slide {{ $index + 1 }}"
                        data-carousel-slide-to="{{ $index }}">
                </button>
            @endforeach
        </div>
    </div>
</div>

{{-- ─── SEARCH / TITLE CARD ─── --}}
<div class="relative z-40 px-6 -mt-16 pb-10">
    <div class="search-card max-w-2xl mx-auto bg-white rounded-2xl p-6 md:p-8">
        <h2 class="font-display font-extrabold text-center mb-6 text-2xl md:text-3xl" style="color: var(--navy);">
            {{ $title }}
        </h2>
        {{-- Search form row --}}
        <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr_1fr_auto] gap-3 items-end">
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold tracking-widest uppercase text-gray-400 pl-1">From</label>
                <input type="text" placeholder="City or airport"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm font-medium text-gray-800 outline-none focus:border-[#000053] focus:bg-white transition-colors"
                       style="font-family: var(--font-body);">
            </div>
            <button onclick="swapInputs()"
                    class="hidden md:flex w-9 h-9 rounded-full border border-gray-200 bg-white items-center justify-center hover:bg-[#000053] hover:border-[#000053] group transition-colors mb-0.5">
                <svg class="w-4 h-4 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M7 16V4m0 0L4 7m3-3l3 3M17 8v12m0 0l3-3m-3 3l-3-3"/>
                </svg>
            </button>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold tracking-widest uppercase text-gray-400 pl-1">To</label>
                <input type="text" placeholder="City or airport"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm font-medium text-gray-800 outline-none focus:border-[#000053] focus:bg-white transition-colors"
                       style="font-family: var(--font-body);">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold tracking-widest uppercase text-gray-400 pl-1">Departing</label>
                <input type="date"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm font-medium text-gray-800 outline-none focus:border-[#000053] focus:bg-white transition-colors"
                       style="font-family: var(--font-body);">
            </div>
            <button class="px-5 py-3 rounded-xl font-display font-bold text-sm text-white tracking-wide hover:-translate-y-0.5 transition-transform"
                    style="background: var(--navy); font-family: var(--font-display);">
                Search →
            </button>
        </div>
    </div>
</div>

{{-- ─── MAIN CONTENT ─── --}}
<main class="flex-1 px-6 pb-12 max-w-screen-xl mx-auto">
    @yield('content')
</main>

{{-- ─── PLANE DIVIDER ─── --}}
<div class="overflow-hidden py-6 relative">
    <div class="flex items-center">
        <div class="flex-1 h-px" style="background: linear-gradient(to right, transparent, #e2e8f0, #e2e8f0, transparent);"></div>
        <svg class="plane-fly w-40 drop-shadow-lg" viewBox="0 0 200 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 40 L160 20 L190 30 L160 40 L10 40Z" fill="#000053" opacity="0.9"/>
            <path d="M50 40 L80 55 L90 40" fill="#1e40af"/>
            <path d="M30 40 L50 50 L55 40" fill="#1e40af"/>
            <path d="M160 30 L175 35 L165 40" fill="#fde047"/>
            <circle cx="175" cy="30" r="4" fill="#fde047"/>
        </svg>
        <div class="flex-1 h-px" style="background: linear-gradient(to right, #e2e8f0, #e2e8f0, transparent);"></div>
    </div>
</div>

{{-- ─── FOOTER ─── --}}
<footer style="background: var(--navy);" class="text-white">
    <div class="max-w-screen-xl mx-auto px-6 pt-12 pb-8">
        <div class="flex flex-wrap justify-between gap-10 pb-8 border-b border-white/10 mb-6">

            {{-- Brand --}}
            <div class="max-w-xs">
                <div class="flex items-center gap-2 font-display font-extrabold text-xl mb-3">
                    <span class="inline-block w-2.5 h-2.5 rounded-full" style="background: var(--yellow);"></span>
                    {{ config('app.name') }}
                </div>
                <p class="text-sm text-white/55 leading-relaxed">
                    Your trusted partner in air travel. Connecting people to the places they love, one flight at a time.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-[0.68rem] font-bold tracking-widest uppercase text-white mb-4">Company</h4>
                <ul class="flex flex-col gap-2.5">
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">About us</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Careers</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Press</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Blog</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[0.68rem] font-bold tracking-widest uppercase text-white mb-4">Support</h4>
                <ul class="flex flex-col gap-2.5">
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Contact</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Claim help</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Flight status</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">FAQ</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[0.68rem] font-bold tracking-widest uppercase text-white mb-4">Legal</h4>
                <ul class="flex flex-col gap-2.5">
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Privacy Policy</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Terms of Service</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Licensing</a></li>
                    <li><a href="#" class="text-sm text-white/55 hover:text-yellow-300 transition-colors no-underline">Cookies</a></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-white/45">
            <p>&copy; 2025 {{ config('app.name') }}. All rights reserved.</p>
            <p>Designed with care for every passenger.</p>
        </div>
    </div>
</footer>

<script>
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 60);
    });

    // Swap From/To inputs
    function swapInputs() {
        const inputs = document.querySelectorAll('input[type="text"]');
        if (inputs.length >= 2) {
            const temp = inputs[0].value;
            inputs[0].value = inputs[1].value;
            inputs[1].value = temp;
        }
    }
</script>
</body>
</html>