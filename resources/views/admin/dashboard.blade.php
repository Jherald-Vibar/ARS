@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <div>
        <div class="mb-1 text-xs font-bold tracking-widest uppercase text-sky">Overview</div>
        <h1 class="text-3xl font-extrabold font-display text-navy">Admin Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Left: Staff Stats --}}
        <div class="flex flex-col gap-6 xl:col-span-1">
            <div class="p-6 transition bg-white border shadow-sm rounded-2xl border-slate-200 hover:shadow-md">
                <div class="flex items-center space-x-4">
                    <div class="bg-navy/8 p-3.5 rounded-xl">
                        <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m6 4a4 4 0 10-8 0 4 4 0 008 0zm4-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Staffs</p>
                        <h2 class="text-2xl font-extrabold font-display text-navy">{{$totalStaffs}}</h2>
                    </div>
                </div>
            </div>

            <div class="p-6 transition bg-white border shadow-sm rounded-2xl border-slate-200 hover:shadow-md">
                <div class="flex items-center space-x-4">
                    <div class="bg-yellow/20 p-3.5 rounded-xl">
                        <svg class="w-6 h-6 text-yellow-deep" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Active Staffs</p>
                        <h2 class="text-2xl font-extrabold font-display text-navy">0</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border shadow-sm rounded-2xl border-slate-200 xl:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold font-display text-navy">Recent Account Creations</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs tracking-wide uppercase bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-semibold">ID</th>
                            <th class="px-4 py-3 font-semibold">Name</th>
                            <th class="px-4 py-3 font-semibold">Email</th>
                            <th class="px-4 py-3 font-semibold">Created At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                         @forelse($staffs as $staff)
                            <tr class="transition hover:bg-slate-50/70">
                                <td class="px-4 py-3 text-slate-400">{{ $staff->id }}</td>
                                <td class="px-4 py-3 font-bold font-display text-navy">{{ $staff->name }}</td>
                                <td class="px-4 py-3">{{ $staff->email }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $staff->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-slate-400">
                                    No recent account creation
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection