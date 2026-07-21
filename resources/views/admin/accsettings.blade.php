@extends('layouts.app')

@section('title', 'Admin Settings')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin-dashboard') }}"
            class="flex items-center justify-center text-lg transition border rounded-full w-9 h-9 border-slate-200 text-navy hover:bg-navy hover:text-white">
            &larr;
        </a>
        <div>
            <div class="text-xs font-bold tracking-widest uppercase text-sky mb-0.5">Account</div>
            <h1 class="text-3xl font-extrabold font-display text-navy">Admin Settings</h1>
        </div>
    </div>

    <div class="p-8 bg-white border shadow-sm rounded-2xl border-slate-200">
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('profile_photos/' . Auth::user()->photo) }}"
                 alt="Profile Photo"
                 class="object-cover w-24 h-24 border-4 rounded-full shadow border-yellow/60">
            <h2 class="mt-4 text-xl font-bold font-display text-navy">Account Settings</h2>
        </div>

        @if (session('success'))
            <div class="p-3 mb-6 text-sm font-medium text-center text-green-700 border border-green-200 rounded-lg bg-green-50">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin-change-pass') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Name</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                       class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none p-2.5 rounded-lg transition">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                       class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none p-2.5 rounded-lg transition">
                @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">New Password</label>
                <input type="password" name="password" class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none p-2.5 rounded-lg transition">
                @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none p-2.5 rounded-lg transition">
            </div>

            <div class="pt-2 text-right">
                <button type="submit" class="font-display font-bold text-sm bg-navy text-white px-6 py-2.5 rounded-lg hover:bg-navy-mid transition">
                    Update Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection