<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="icon" href="{{ asset('web_images/image 1.png') }}">
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
    <div class="absolute -top-20 left-1/2 transform -translate-x-1/2 z-40 w-3/4 max-w-xl bg-[#00205D] shadow-lg rounded-xl p-2 mt-6">
        <div class="mb-4">
            <h1 class="text-[35px] font-bold text-center text-white ">{{$title}}</h1>
        </div>
    </div>
</div>




    <main class="flex-1 p-6 ">
        @yield('content')
    </main>


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
