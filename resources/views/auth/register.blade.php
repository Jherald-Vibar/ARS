<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - {{ config('app.name') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4">

  <div class="flex flex-col md:flex-row items-center md:items-start max-w-5xl w-full bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="w-full md:w-1/2 h-64 md:h-auto">
      <img src="{{ asset('web_images/Rectangle 44.png') }}"
           alt="Register Image"
           class="w-full h-full object-cover" />
    </div>
    <div class="w-full md:w-1/2 p-8">
        <div class="max-w-md mx-auto">
            <div>
            <h2 class="text-4xl font-bold text-gray-900">Create Account</h2>
            <p class="mt-2 text-sm text-gray-600">Sign up to start booking flights.</p>
            </div>
            <form action="{{route('passenger-store')}}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <input name="name" type="text" placeholder="Full Name"
                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400" />
                <input name="date_of_birth" type="date"
                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400" />
            </div>
            <input name="email" type="email" placeholder="Email"
                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400" />
            <input name="password" type="password" placeholder="Password"
                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400" />
            <input name="address" type="text" placeholder="Address"
                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400" />
            <div class="grid grid-cols-2 gap-4">
                <input name="contact_number" type="text" placeholder="Contact Number"
                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400" />

                <input name="passport_number" type="text" placeholder="Passport Number"
                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400" />

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                Register
            </button>

            <div class="text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('loginForm') }}" class="text-blue-600 hover:underline">Login here</a>
            </div>
            </form>
        </div>
    </div>
  </div>

</body>
</html>
