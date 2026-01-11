<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('web_images/image 1.png') }}">
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen">
       <aside class="bg-[#00205D] fixed text-white w-64 p-6 space-y-8 h-screen shadow-lg flex flex-col justify-between">
            <div class="space-y-8">
                <div class="flex flex-col items-center space-y-2">
                    <svg
                        class="w-20 h-20 rounded-full border-2 border-white bg-blue-700 p-2"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <circle cx="12" cy="7" r="4" />
                        <path d="M5.5 21a6.5 6.5 0 0113 0" />
                    </svg>
                    <div class="text-center">
                        <h2 class="text-lg font-semibold">{{ Auth::user()->name }}</h2>
                        <p class="text-sm text-blue-300">Administrator</p>
                    </div>
                </div>


                <nav class="space-y-2">
                    <a
                        href="{{route('admin-dashboard')}}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a
                        href="{{route('admin-staff-list')}}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="9" cy="7" r="4" />
                            <path d="M17 11v2a4 4 0 01-4 4H7" />
                            <path d="M19 16v-1a4 4 0 00-4-4h-1" />
                        </svg>
                        <span>Staffs</span>
                    </a>
                    <a
                        href="{{route('admin-aircraft-list')}}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="9" cy="7" r="4" />
                            <path d="M17 11v2a4 4 0 01-4 4H7" />
                            <path d="M19 16v-1a4 4 0 00-4-4h-1" />
                        </svg>
                        <span>Aircraft</span>
                    </a>
                    <a
                        href="{{route('admin-airport-list')}}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-800 transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="9" cy="7" r="4" />
                            <path d="M17 11v2a4 4 0 01-4 4H7" />
                            <path d="M19 16v-1a4 4 0 00-4-4h-1" />
                        </svg>
                        <span>Airport</span>
                    </a>
                </nav>

                <hr class="border-blue-900 my-4">

                <div class="relative">
                    <button
                        id="settingsToggle"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-blue-800 transition"
                    >
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Settings</span>
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                        </svg>
                    </button>

                    <div
                        id="settingsMenu"
                        class="hidden ml-8 mt-2 space-y-2 transition"
                    >
                      <a href="{{ route('admin-acc-profile') }}"
                        class="block px-2 py-1 text-sm rounded hover:bg-blue-700 transition">
                        Account Profile
                      </a>
                        <a href="{{ route('admin-acc-settings') }}"
                           class="block px-2 py-1 text-sm rounded hover:bg-blue-700 transition">
                            Account Settings
                        </a>
                    </div>
                </div>


            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-red-600 transition text-red-300 hover:text-white"
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


        {{-- Main Content --}}
        <main class="flex-1 p-6  ml-64">
           @yield('content')
        </main>
    </div>

    <script>
        const settingsToggle = document.getElementById('settingsToggle');
        const settingsMenu = document.getElementById('settingsMenu');

        settingsToggle.addEventListener('click', function () {
            settingsMenu.classList.toggle('hidden');
        });

        // Optional: Close dropdown if clicking outside
        document.addEventListener('click', function (event) {
            if (!settingsToggle.contains(event.target) && !settingsMenu.contains(event.target)) {
                settingsMenu.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
