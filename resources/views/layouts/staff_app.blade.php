<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="icon" href="{{ asset('web_images/image 1.png') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#000053',
                        'navy-mid': '#0a0a7a',
                        'navy-light': '#1a1aa0',
                        blueaccent: '#1e40af',
                        sky: '#3b82f6',
                        yellow: '#fde047',
                        'yellow-deep': '#f59e0b',
                    },
                    fontFamily: {
                        display: ['Syne', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        .nav-item {
            position: relative;
            transition: background 0.2s, color 0.2s;
        }
        .nav-item.active {
            background: rgba(253, 224, 71, 0.12);
            color: #fde047;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -1.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: #fde047;
            border-radius: 0 4px 4px 0;
        }
        .nav-item:not(.active):hover {
            background: rgba(255, 255, 255, 0.06);
        }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }
    </style>
</head>
<body class="antialiased bg-gray-50 font-body text-slate-800">
    <div class="flex h-screen">
        @auth('staff')
        <aside class="fixed flex flex-col justify-between w-64 h-screen overflow-hidden shadow-2xl bg-navy">
            <div class="absolute inset-0 pointer-events-none opacity-60"
                 style="background: radial-gradient(ellipse 80% 40% at 50% 0%, rgba(30,64,175,0.35) 0%, transparent 70%);"></div>

            <div class="relative z-10 p-6 space-y-8 overflow-y-auto sidebar-scroll">
                <a href="{{ route('staff-dashboard') }}" class="flex items-center gap-2 text-lg font-extrabold text-white font-display">
                    <span class="w-2.5 h-2.5 bg-yellow rounded-full inline-block"></span>
                    <span>{{config('app.name')}}</span>
                </a>

                <div class="flex flex-col items-center py-4 space-y-3 border-y border-white/10">
                    <svg class="w-16 h-16 p-3 border-2 rounded-full border-yellow/60 bg-blueaccent/30"
                        fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="7" r="4" />
                        <path d="M5.5 21a6.5 6.5 0 0113 0" />
                    </svg>
                    <div class="text-center">
                        <h2 class="font-bold text-white font-display">{{ Auth::user()->name }}</h2>
                        <p class="text-xs tracking-widest uppercase text-yellow/80">Staff</p>
                    </div>
                </div>

                <nav class="space-y-1 pl-1.5">
                    <a href="{{ route('staff-dashboard') }}"
                        class="nav-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('staff-flights-list') }}"
                        class="nav-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="9" cy="7" r="4" />
                            <path d="M17 11v2a4 4 0 01-4 4H7" />
                            <path d="M19 16v-1a4 4 0 00-4-4h-1" />
                        </svg>
                        <span>Flights</span>
                    </a>
                    <a href="{{route('staff-bookings')}}"
                        class="nav-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3M5 11h14M5 19h14M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                        <span>Bookings</span>
                    </a>
                    <!--<a href="" class="nav-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 3v18M6 8v13M16 13v8M21 6v15" />
                        </svg>
                        <span>Reports</span>
                    </a>-->
                </nav>
            </div>

            <div class="relative z-10 p-6 pt-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-red-300/80 hover:text-white hover:bg-red-500/80 transition text-sm font-medium"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        @endauth

        {{-- Main Content --}}
        <main class="flex-1 p-8 ml-64">
           @yield('content')
        </main>
    </div>

    <script>
        document.querySelectorAll('.nav-item').forEach(link => {
            if (link.getAttribute('href') === window.location.pathname) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>