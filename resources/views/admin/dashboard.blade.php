@extends('layouts.app')

@section('content')
<div class="space-y-6 min-h-screen">
    {{-- Page Header --}}
    <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>

    {{-- Main Layout: Left and Right Side-by-Side --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 h-[600px]"> {{-- Fixed height for alignment --}}

        {{-- Left: Staff Stats --}}
        <div class="flex flex-col justify-between h-full space-y-6 xl:col-span-1">
            {{-- Total Staffs --}}
            <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition h-1/2">
                <div class="flex items-center space-x-4 h-full">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m6 4a4 4 0 10-8 0 4 4 0 008 0zm4-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Staffs</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{$totalStaffs}}</h2>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition h-1/2">
                <div class="flex items-center space-x-4 h-full">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Active Staffs</p>
                        <h2 class="text-2xl font-bold text-gray-800">0</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md xl:col-span-2 h-full overflow-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700">Recent Account Creations</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Created At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                         @forelse($staffs as $staff)
                            <tr>
                                <td class="px-4 py-3">{{ $staff->id }}</td>
                                <td class="px-4 py-3">{{ $staff->name }}</td>
                                <td class="px-4 py-3">{{ $staff->email }}</td>
                                <td class="px-4 py-3">{{ $staff->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center px-4 py-6 text-gray-400">
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
