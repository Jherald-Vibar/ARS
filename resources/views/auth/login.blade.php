<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ config('app.name') }}</title>
  <link rel="icon" href="{{asset('web_images/image 1.png')}}">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex">
<div class="relative w-full md:w-1/4 bg-transparent p-8 flex flex-col justify-center min-h-screen overflow-hidden">
    <h2 class="relative text-5xl font-bold text-black mb-6 z-10">LOGIN</h2>
    <h6 class="relative text-lg text-gray-600 mb-6 z-10">Welcome back, please login to your account.</h6>
    <div class="custom-shape"></div>
    <form action="{{route('authenticate')}}" method="POST" class="space-y-5 relative z-10">
      @csrf
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" name="email" type="email" placeholder="Enter your email"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700 shadow-sm" required/>
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input id="password" name="password" type="password" placeholder="••••••••"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700 shadow-sm" required/>
      </div>
      <div class="flex items-center justify-between relative z-10">
        <a href="#" class="text-sm text-blue-500 hover:underline">Forgot Password?</a>
      </div>
      <div class="flex justify-start items-center gap-4 relative z-10">
        <button type="submit"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center">
          Login
        </button>
        <button type="button"
          onclick='window.location.href="{{route("registerForm")}}"'
          class="text-blue-700 bg-white border border-blue-700 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center transition duration-200">
          Sign up
        </button>
      </div>
    </form>
    <p class="text-xs text-center text-gray-400 mt-6 relative z-10">
      &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </p>
  </div>

  <div class="hidden md:block w-3/4 h-screen overflow-hidden">
    <img src="{{ asset('web_images/Ellipse 2.png') }}"
         alt="Login Image"
         class="w-full h-full object-cover rounded-l-[100px]" />
  </div>

</body>
</html>
