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
    <style>
        @keyframes float {
            0% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(500px);
            }
            50% {
                transform: translateX(0);
            }
            75%{
                transform: translateX(-500px);
            }
            100% {
                transform: translateX(0);
            }
        }

        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans">

    <!-- Navbar -->
    <nav class="absolute top-0 right-0 z-50 p-4 bg-transparent">
        <ul class="flex space-x-4 font-bold text-sm">
            <li><a href="#" class="hover:text-blue-600">Home</a></li>
            <li><a href="#" class="hover:text-blue-600">Flight</a></li>
            <li><a href="#" class="hover:text-blue-600">About</a></li>
            <li><a href="#" class="hover:text-blue-600">Contact</a></li>
            <li>
                <div class="flex items-center gap-1">
                    <img src="{{ asset('web_images/image 1.png') }}" alt="User Icon" class="w-6 h-6">
                    <a href="{{route('loginForm')}}" class="hover:text-blue-600">Login</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Carousel -->
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <div class="relative h-56 overflow-hidden md:h-96">
            @for ($i = 0; $i < 5; $i++)
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="{{ asset('web_images/Rectangle 6.png') }}" alt="Slide {{ $i + 1 }}"
                         class="absolute block w-full h-full object-cover top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                </div>
            @endfor
        </div>

        <!-- Carousel indicators -->
        <div class="absolute z-30 flex bottom-5 left-1/2 -translate-x-1/2 space-x-3">
            @for ($i = 0; $i < 5; $i++)
                <button type="button" class="w-3 h-3 bg-white rounded-full" aria-label="Slide {{ $i + 1 }}" data-carousel-slide-to="{{ $i }}"></button>
            @endfor
        </div>

        <!-- Carousel controls -->
        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 group" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 bg-white/30 rounded-full group-hover:bg-white/50">
                <svg class="w-4 h-4 text-white" viewBox="0 0 6 10" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
            </span>
        </button>
        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 group" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 bg-white/30 rounded-full group-hover:bg-white/50">
                <svg class="w-4 h-4 text-white" viewBox="0 0 6 10" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
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
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <input type="text" name="departing" placeholder="Departing on" class="p-3 border border-gray-300 rounded-md text-sm placeholder-gray-500 focus:ring-2 focus:ring-blue-500" />
                <button type="submit" class="bg-[#000053] text-white py-3 rounded-md hover:bg-blue-700 transition w-full">Search Flight</button>
            </form>
        </div>
    </div>

    <div class="mt-24 px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700">
            <img src="{{ asset('web_images/Group 15.png') }}" width="64" alt="">
            <h5 class="text-2xl font-semibold text-black dark:text-black mb-2">Need help with a Claim?</h5>
            <p class="text-gray-500 dark:text-gray-400 mb-3">Follow this step-by-step guide to certify for your weekly benefits:</p>
            <a href="#" class="text-blue-600 hover:underline inline-flex items-center font-medium">
                See our guideline
                <svg class="w-3 h-3 ml-2 rtl:rotate-180" viewBox="0 0 18 18" fill="none">
                    <path stroke="currentColor" stroke-width="2" d="M5 9h8M11 5l4 4-4 4"/>
                </svg>
            </a>
        </div>
         <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700">
            <img src="{{ asset('web_images/Group 16.png') }}" width="64" alt="">
            <h5 class="text-2xl font-semibold text-black dark:text-black     mb-2">Need help with a Claim?</h5>
            <p class="text-gray-500 dark:text-gray-400 mb-3">Follow this step-by-step guide to certify for your weekly benefits:</p>
            <a href="#" class="text-blue-600 hover:underline inline-flex items-center font-medium">
                See our guideline
                <svg class="w-3 h-3 ml-2 rtl:rotate-180" viewBox="0 0 18 18" fill="none">
                    <path stroke="currentColor" stroke-width="2" d="M5 9h8M11 5l4 4-4 4"/>
                </svg>
            </a>
        </div>
         <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700">
            <img src="{{ asset('web_images/Group 17.png') }}" width="64" alt="">
            <h5 class="text-2xl font-semibold text-black dark:text-black mb-2">Need help with a Claim?</h5>
            <p class="text-gray-500 dark:text-gray-400 mb-3">Follow this step-by-step guide to certify for your weekly benefits:</p>
            <a href="#" class="text-blue-600 hover:underline inline-flex items-center font-medium">
                See our guideline
                <svg class="w-3 h-3 ml-2 rtl:rotate-180" viewBox="0 0 18 18" fill="none">
                    <path stroke="currentColor" stroke-width="2" d="M5 9h8M11 5l4 4-4 4"/>
                </svg>
            </a>
        </div>
    </div>

    <div class="p-5 flex flex-col md:flex-row items-center bg-white rounded-lg overflow-hidden" style="height: 400px">
        <div class="w-full md:w-1/2 h-64 md:h-auto">
            <img src="{{ asset('web_images/Rectangle 6.png') }}" alt="Description Image"
                class="w-full h-full object-cover">
        </div>

        <div class="w-full md:w-1/2 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Title Here</h2>
            <p class="text-gray-600 text-sm leading-relaxed">
                This is a sample description area where you can write about the image or your content.
                It supports responsive design and will stack on smaller screens.
            </p>
        </div>
    </div>


    <div class="mt-6 flex items-center">
        <hr class="flex-grow border-t-2 border-gray-300">
        <span class="mx-4 text-3xl font-bold font-arial text-yellow-300">UPCOMING FLIGHTS</span>
        <hr class="flex-grow border-t-2 border-gray-300">
    </div>


    <div class="mt-6 p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to Tokyo
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-20">May 20, 2025</time><br />
                Time: 10:00 AM
            </p>
            </div>
        </div>

        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to Paris
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-21">May 21, 2025</time><br />
                Time: 1:30 PM
            </p>
            </div>
        </div>

        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to New York
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-22">May 22, 2025</time><br />
                Time: 3:45 PM
            </p>
            </div>
        </div>

        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to London
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-23">May 23, 2025</time><br />
                Time: 6:15 AM
            </p>
            </div>
        </div>

        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to Dubai
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-24">May 24, 2025</time><br />
                Time: 9:00 AM
            </p>
            </div>
        </div>

        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to Rome
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-25">May 25, 2025</time><br />
                Time: 2:00 PM
            </p>
            </div>
        </div>

        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to Sydney
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-26">May 26, 2025</time><br />
                Time: 11:00 PM
            </p>
            </div>
        </div>

        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to Seoul
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-27">May 27, 2025</time><br />
                Time: 7:00 AM
            </p>
            </div>
        </div>

        <div
            class="flex bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg cursor-pointer"
        >
            <div class="w-1/3 overflow-hidden">
            <img
                src="{{ asset('web_images/Rectangle 6.png') }}"
                alt="Flight Image"
                class="object-cover w-full h-full rounded-l-xl"
            />
            </div>
            <div class="p-5 w-2/3 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                Flight to Bangkok
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Departure: <time datetime="2025-05-28">May 28, 2025</time><br />
                Time: 5:45 PM
            </p>
            </div>
        </div>
    </div>

   <section class="max-w-4xl mx-auto my-12 p-6">
    <img
        src="{{asset('web_images/airplanee.png')}}"
        alt="Airplane flying in the sky"
        class="w-full h-auto object-cover animate-float"
    />
    </section>

   <div class="max-w-5xl mx-auto px-6 py-10 text-center font-sans">
    <h2 class="text-3xl font-semibold mb-10 text-gray-800 tracking-wide">OUR HAPPY PASSENGERS</h2>
        <div class="flex flex-wrap justify-center gap-8">
            <div class="bg-gray-100 rounded-xl shadow-md p-6 max-w-sm flex-1 hover:-translate-y-2 transition-transform duration-300">
            <p class="italic text-gray-600 mb-4">"Amazing service! The trip was comfortable and on time."</p>
            <p class="font-semibold text-gray-800">- John D.</p>
            </div>

            <div class="bg-gray-100 rounded-xl shadow-md p-6 max-w-sm flex-1 hover:-translate-y-2 transition-transform duration-300">
            <p class="italic text-gray-600 mb-4">"Friendly staff and excellent support throughout the journey."</p>
            <p class="font-semibold text-gray-800">- Sarah W.</p>
            </div>

            <div class="bg-gray-100 rounded-xl shadow-md p-6 max-w-sm flex-1 hover:-translate-y-2 transition-transform duration-300">
            <p class="italic text-gray-600 mb-4">"Clean vehicles and great value for the price."</p>
            <p class="font-semibold text-gray-800">- Michael B.</p>
            </div>
        </div>
    </div>
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
