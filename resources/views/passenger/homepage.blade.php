<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="icon" href="{{ asset('web_images/image 1.png') }}">
    <title>{{ config('app.name') }}</title>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-white text-gray-900 font-sans">
    <nav class="fixed top-0 right-0 z-50 p-4 w-full bg-white shadow-md">
        @auth('passenger')
        <ul class="flex justify-end items-center space-x-6 font-semibold text-sm text-gray-700">
            <li><a href="{{ route('passenger-dashboard') }}" class="hover:text-blue-600">Home</a></li>
            <li><a href="#" class="hover:text-blue-600">Flight</a></li>
            <li x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                    <img src="{{ asset('web_images/image 1.png') }}" alt="User Icon" class="w-6 h-6 rounded-full">
                    <span class="hover:text-blue-600">{{ Auth::guard('passenger')->user()->name }}</span>
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-md z-50">
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        @endauth
    </nav>

    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <div class="relative h-64 md:h-96 overflow-hidden rounded-lg">
            @foreach (['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'] as $index => $carouselImage)
                <div class="{{ $index === 0 ? 'block' : 'hidden' }} duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('web_images/'.$carouselImage) }}" alt="Slide {{ $index + 1 }}"
                        class="absolute block w-full h-full object-cover top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                </div>
            @endforeach
        </div>
        <div class="absolute z-30 flex bottom-5 left-1/2 -translate-x-1/2 space-x-3">
            @foreach (['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'] as $index => $carouselImage)
                <button type="button" class="w-3 h-3 bg-white rounded-full" aria-label="Slide {{ $index + 1 }}"
                    data-carousel-slide-to="{{ $index }}"></button>
            @endforeach
        </div>
        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 group" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 bg-white/30 rounded-full group-hover:bg-white/50">
                <svg class="w-4 h-4 text-white" viewBox="0 0 6 10" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
            </span>
        </button>
        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 group" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 bg-white/30 rounded-full group-hover:bg-white/50">
                <svg class="w-4 h-4 text-white" viewBox="0 0 6 10" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 9l4-4-4-4" />
                </svg>
            </span>
        </button>
    </div>

    <div class="relative">
        <div class="absolute -top-20 left-1/2 transform -translate-x-1/2 z-40 w-11/12 max-w-6xl bg-white shadow-lg rounded-xl p-5">
            <div class="flex items-center mb-4 space-x-4">
                <img src="{{ asset('web_images/image 1.png') }}" class="w-8 h-8 rounded-full" alt="Logo">
                <h4 class="text-lg font-bold">Flight</h4>
            </div>
            <form method="GET" action="{{route('passenger-dashboard')}}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center space-x-2">
                    <input type="text" name="from" placeholder="From" class="w-full p-3 border border-gray-300 rounded-md text-sm placeholder-gray-500 focus:ring-2 focus:ring-blue-500" />
                    <svg width="30px" height="30px" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>cycle</title>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="icon" fill="#000000" transform="translate(64.000000, 58.823665)">
                                <path d="M384,175.843 L384,197.176335 C384,267.868783 326.692448,325.176335 256,325.176335 L256,325.176335 L97.849,325.176 L136.836556,364.18278 L106.666667,394.352669 L16.1569987,303.843001 L106.666667,213.333333 L136.836556,243.503223 L97.849,282.509 L256,282.509668 C302.657016,282.509668 340.56834,245.064914 341.321901,198.587477 L341.333333,197.176335 L341.333,175.843 L384,175.843 Z M277.333333,1.42108547e-14 L367.843001,90.509668 L277.333333,181.019336 L247.163444,150.849447 L286.15,111.843 L128,111.843001 C81.3429843,111.843001 43.4316597,149.287756 42.6780989,195.765192 L42.6666667,197.176335 L42.666,218.509 L1.42108547e-14,218.509 L1.42108547e-14,197.176335 C-8.42864619e-15,127.190811 56.1671317,70.3238242 125.883286,69.193483 L128,69.1763347 L286.151,69.176 L247.163444,30.1698893 L277.333333,1.42108547e-14 Z" id="Rectangle">
                                </path>
                            </g>
                        </g>
                    </svg>
                    <input type="text" name="to" placeholder="To" class="w-full p-3 border border-gray-300 rounded-md text-sm placeholder-gray-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <input type="date" name="departing" placeholder="Departing on" class="p-3 border border-gray-300 rounded-md text-sm placeholder-gray-500 focus:ring-2 focus:ring-blue-500" />
                <button type="submit" class="bg-[#000053] text-white py-3 rounded-md hover:bg-blue-700 transition w-full">Search Flight</button>
            </form>
        </div>
    </div>

    <div class="mt-24 max-w-6xl mx-auto px-4">
        <div class="overflow-x-auto bg-gray-200 rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Flight No.</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">From</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">To</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Arrival</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-left divide-gray-200">
                    @foreach ($flights as $flight )
                    @php
                        preg_match('/\d+$/', $flight->flight_number, $numberMatch);
                        $number = $numberMatch[0] ?? '';

                        $lettersOnly = preg_replace('/\d+/', '', $flight->flight_number);
                        $consonants = preg_replace('/[aeiou\s]/i', '', $lettersOnly);

                        $flightNumber = strtoupper($consonants) . $number;
                    @endphp
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{$flightNumber}}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{$flight->departureAirport->name}}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{$flight->arrivalAirport->name}}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{$flight->arrival_date}} : {{$flight->arrival_time}}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <button
                            onclick="window.location.href='{{route('passenger-booking', ['fid' => $flight->id])}}'"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Book
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                {{$flights->links()}}
            </table>
        </div>
    </div>

    <div class="mt-6 mb-4 flex items-center">
        <hr class="flex-grow border-t-2 border-gray-300">
        <span class="mx-4 text-3xl font-bold font-arial text-yellow-300">UPCOMING FLIGHTS</span>
        <hr class="flex-grow border-t-2 border-gray-300">
    </div>

    <div class="px-4 max-w-6xl mx-auto pb-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($upcomingFlights as $flight)
         @php
            preg_match('/\d+$/', $flight->flight_number, $numberMatch);
            $number = $numberMatch[0] ?? '';

            $lettersOnly = preg_replace('/\d+/', '', $flight->flight_number);
            $consonants = preg_replace('/[aeiou\s]/i', '', $lettersOnly);

            $flightNumber = strtoupper($consonants) . $number;
        @endphp
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition duration-300 hover:shadow-xl hover:scale-[1.02]">
            <div class="relative aspect-[3/2]">
                <img src="{{ asset('web_images/Rectangle 6.png') }}" alt="Flight Image"
                    class="absolute inset-0 w-full h-full object-cover">
            </div>
            <div class="p-5">
                <h3 class="text-xl font-semibold text-gray-800 mb-1">{{$flightNumber}}</h3>
                <p class="text-sm text-gray-500">Departure: {{\Carbon\Carbon::parse($flight->departure_date)->format('M-d Y')}}</p>
                <div class="mt-4">
                    <a href="#" class="inline-block bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <footer class="bg-blue-900 rounded-lg shadow-sm text-white">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="https://flowbite.com/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{asset('web_images/image 1.png')}}" class="h-8" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap">{{config('app.name')}}</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-white sm:mb-0">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-blue-800 sm:mx-auto lg:my-8" />
        <span class="block text-sm text-white sm:text-center">&copy; 2025 <a href="{{asset('web_images/image 1.png')}}" class="hover:underline">{{config('app.name')}}</a>. All Rights Reserved.</span>
    </div>
</footer>

</body>
</html>
