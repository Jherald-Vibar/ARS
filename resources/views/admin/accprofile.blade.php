@extends('layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin-dashboard') }}"
            class="flex items-center justify-center text-lg transition border rounded-full w-9 h-9 border-slate-200 text-navy hover:bg-navy hover:text-white">
            &larr;
        </a>
        <div>
            <div class="text-xs font-bold tracking-widest uppercase text-sky mb-0.5">Account</div>
            <h1 class="text-3xl font-extrabold font-display text-navy">Admin Profile</h1>
        </div>
    </div>

    <div class="p-8 bg-white border shadow-sm rounded-2xl border-slate-200">
        <h3 class="pb-4 mb-6 text-xl font-bold border-b font-display text-navy border-slate-100">About you</h3>
        <div class="space-y-6">
            <div>
                <label class="text-xs font-semibold tracking-wide uppercase text-slate-500">Name</label>
                <input type="text" value="{{ Auth::user()->name }}" class="w-full px-4 py-3 mt-2 text-base border rounded-lg bg-slate-50 border-slate-200" disabled>
            </div>

            <div>
                <label class="text-xs font-semibold tracking-wide uppercase text-slate-500">Email</label>
                <input type="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-3 mt-2 text-base border rounded-lg bg-slate-50 border-slate-200" disabled>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection