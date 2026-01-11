@extends('layouts.app')

@section('title', 'Admin Settings')

@section('content')

<div class="text-4xl font-bold text-gray-800 mb-6 flex items-center gap-2" style="color:#001840">
    <a href="{{ route('admin-dashboard') }}" class="text-blue-500 hover:underline text-2xl">&larr;</a>
    Admin Settings
</div>

    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow">
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('profile_photos/' . Auth::user()->photo) }}"
                 alt="Profile Photo"
                 class="w-24 h-24 rounded-full object-cover border-4 border-black-200 shadow">
            <h2 class="text-2xl font-bold mt-4">Account Settings</h2>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin-change-pass') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                       class="w-full border border-gray-300 p-2 rounded">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                       class="w-full border border-gray-300 p-2 rounded">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Update Settings
                </button>
            </div>
        </form>
    </div>
@endsection
