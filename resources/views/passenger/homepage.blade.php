<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="icon" href="{{ asset('web_images/image 1.png') }}">
    <title>{{ config('app.name') }}</title>
    <script src="//unpkg.com/alpinejs" defer></script>
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
    </style>
</head>
<body class="antialiased bg-gray-50 text-slate-800 font-body">
    <nav class="fixed top-0 left-0 right-0 z-50 shadow-lg bg-navy/95 backdrop-blur-md">
        @auth('passenger')
        <div class="flex items-center justify-between max-w-6xl px-4 py-3 mx-auto">
            <a href="{{ route('passenger-dashboard') }}" class="flex items-center gap-2 text-lg font-extrabold text-white font-display">
                <span class="w-2.5 h-2.5 bg-yellow rounded-full inline-block"></span>
                <span>{{config('app.name')}}</span>
            </a>
            <ul class="flex items-center justify-end space-x-8 text-sm font-medium text-white/80">
                <li><a href="{{ route('passenger-dashboard') }}" class="transition hover:text-yellow">Home</a></li>
                <li><a href="#" class="transition hover:text-yellow">Flight</a></li>
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 transition focus:outline-none text-white/80 hover:text-white">
                        <img src="{{ asset('web_images/image 1.png') }}" alt="User Icon" class="border rounded-full w-7 h-7 border-yellow/50">
                        <span>{{ Auth::guard('passenger')->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 z-50 w-40 mt-2 overflow-hidden bg-white border rounded-lg shadow-xl border-slate-100">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-red-500 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        @endauth
    </nav>

    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <div class="relative h-72 md:h-[28rem] overflow-hidden">
            @foreach (['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'] as $index => $carouselImage)
                <div class="{{ $index === 0 ? 'block' : 'hidden' }} duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('web_images/'.$carouselImage) }}" alt="Slide {{ $index + 1 }}"
                        class="absolute block object-cover w-full h-full transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 brightness-75">
                </div>
            @endforeach
            <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(to bottom, rgba(0,0,83,0.35) 0%, rgba(0,0,83,0.55) 100%);"></div>
        </div>
        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-6 left-1/2">
            @foreach (['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'] as $index => $carouselImage)
                <button type="button" class="w-2.5 h-2.5 bg-white/60 rounded-full transition" aria-label="Slide {{ $index + 1 }}"
                    data-carousel-slide-to="{{ $index }}"></button>
            @endforeach
        </div>
        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 group" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 transition rounded-full bg-white/20 group-hover:bg-white/35">
                <svg class="w-4 h-4 text-white" viewBox="0 0 6 10" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
            </span>
        </button>
        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 group" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 transition rounded-full bg-white/20 group-hover:bg-white/35">
                <svg class="w-4 h-4 text-white" viewBox="0 0 6 10" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 9l4-4-4-4" />
                </svg>
            </span>
        </button>
    </div>

    <div class="relative">
        <div class="absolute z-40 w-11/12 max-w-5xl p-6 transform -translate-x-1/2 bg-white shadow-2xl -top-16 left-1/2 rounded-2xl">
            <div class="flex items-center mb-5 space-x-3">
                <span class="w-2.5 h-2.5 bg-yellow rounded-full inline-block"></span>
                <h4 class="text-lg font-bold font-display text-navy">Find a Flight</h4>
            </div>
            <form method="GET" action="{{route('passenger-dashboard')}}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1.5">From</label>
                    <input type="text" name="from" placeholder="City or airport" class="w-full px-3.5 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none rounded-lg text-sm transition" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1.5">To</label>
                    <input type="text" name="to" placeholder="City or airport" class="w-full px-3.5 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none rounded-lg text-sm transition" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1.5">Departing</label>
                    <input type="date" name="departing" class="w-full px-3.5 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none rounded-lg text-sm transition" />
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full font-display font-bold text-sm bg-navy text-white py-2.5 rounded-lg hover:bg-navy-mid transition">
                        Search Flights →
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-6xl px-4 mx-auto mt-28">
        <div class="overflow-x-auto bg-white border shadow-sm rounded-2xl border-slate-200">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wide text-left uppercase text-slate-500">Flight No.</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wide text-left uppercase text-slate-500">From</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wide text-left uppercase text-slate-500">To</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wide text-left uppercase text-slate-500">Arrival</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wide text-right uppercase text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody class="text-left divide-y divide-slate-100">
                    @foreach ($flights as $flight )
                    @php
                        preg_match('/\d+$/', $flight->flight_number, $numberMatch);
                        $number = $numberMatch[0] ?? '';

                        $lettersOnly = preg_replace('/\d+/', '', $flight->flight_number);
                        $consonants = preg_replace('/[aeiou\s]/i', '', $lettersOnly);

                        $flightNumber = strtoupper($consonants) . $number;
                    @endphp
                    <tr class="transition hover:bg-slate-50/70">
                        <td class="px-6 py-4 text-sm font-bold font-display text-navy">{{$flightNumber}}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{$flight->departureAirport->name}}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{$flight->arrivalAirport->name}}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{$flight->arrival_date}} : {{$flight->arrival_time}}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <button
                            onclick="window.location.href='{{route('passenger-booking', ['fid' => $flight->id])}}'"
                            class="px-4 py-2 text-sm font-semibold text-white transition rounded-lg bg-navy hover:bg-navy-mid">
                                Book
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{$flights->links()}}
        </div>
    </div>

    <div class="flex items-center max-w-6xl gap-4 px-4 mx-auto mt-16 mb-8">
        <hr class="flex-grow border-t border-slate-200">
        <div class="text-center">
            <div class="mb-1 text-xs font-bold tracking-widest uppercase text-sky">Departing soon</div>
            <span class="text-2xl font-extrabold font-display text-navy">Upcoming Flights</span>
        </div>
        <hr class="flex-grow border-t border-slate-200">
    </div>

    <div class="grid max-w-6xl grid-cols-1 gap-6 px-4 pb-16 mx-auto sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($upcomingFlights as $flight)
         @php
            preg_match('/\d+$/', $flight->flight_number, $numberMatch);
            $number = $numberMatch[0] ?? '';

            $lettersOnly = preg_replace('/\d+/', '', $flight->flight_number);
            $consonants = preg_replace('/[aeiou\s]/i', '', $lettersOnly);

            $flightNumber = strtoupper($consonants) . $number;
        @endphp
        <div class="overflow-hidden transition duration-300 bg-white border shadow-sm rounded-2xl border-slate-200 hover:shadow-lg hover:-translate-y-1">
            <div class="relative aspect-[3/2]">
                <img src="{{ asset('web_images/Rectangle 6.png') }}" alt="Flight Image"
                    class="absolute inset-0 object-cover w-full h-full">
                <span class="absolute top-3 left-3 bg-navy/85 text-yellow text-xs font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm">
                    {{$flightNumber}}
                </span>
            </div>
            <div class="p-5">
                <h3 class="mb-1 text-lg font-bold font-display text-navy">{{$flightNumber}}</h3>
                <p class="text-sm text-slate-500">Departure: {{\Carbon\Carbon::parse($flight->departure_date)->format('M-d Y')}}</p>
                <div class="mt-4">
                    <a href="#" class="inline-block px-4 py-2 text-sm font-semibold text-white transition rounded-lg bg-navy hover:bg-navy-mid">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <footer class="bg-navy text-white/65">
        <div class="max-w-6xl px-4 py-10 mx-auto">
            <div class="pb-6 border-b sm:flex sm:items-center sm:justify-between border-white/10">
                <a href="{{ route('passenger-dashboard') }}" class="flex items-center gap-2 mb-4 text-lg font-extrabold text-white sm:mb-0 font-display">
                    <span class="w-2.5 h-2.5 bg-yellow rounded-full inline-block"></span>
                    <span>{{config('app.name')}}</span>
                </a>
                <ul class="flex flex-wrap items-center gap-6 text-sm font-medium">
                    <li><a href="#" class="transition hover:text-yellow">About</a></li>
                    <li><a href="#" class="transition hover:text-yellow">Privacy Policy</a></li>
                    <li><a href="#" class="transition hover:text-yellow">Licensing</a></li>
                    <li><a href="#" class="transition hover:text-yellow">Contact</a></li>
                </ul>
            </div>
            <span class="block mt-6 text-sm">&copy; 2025 {{config('app.name')}}. All Rights Reserved.</span>
        </div>
    </footer>

</body>
</html>