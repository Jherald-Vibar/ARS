@extends('layouts.staff_app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <div class="mb-1 text-xs font-bold tracking-widest uppercase text-sky">Reservations</div>
        <h1 class="text-3xl font-extrabold font-display text-navy">All Bookings</h1>
    </div>

    <div class="overflow-x-auto bg-white border shadow-sm rounded-2xl border-slate-200">
        <table class="min-w-full text-sm text-left text-slate-700">
            <thead class="text-xs tracking-wide uppercase bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">Passenger(s)</th>
                    <th class="px-6 py-4 font-semibold">Flight</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold">Booked At</th>
                    <th class="px-6 py-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($bookings as $booking)
                <tr class="transition hover:bg-slate-50/70">
                    <td class="px-6 py-4 text-slate-400">{{ $booking->id }}</td>
                    <td class="px-6 py-4">
                        @foreach($booking->passengers as $passenger)
                            <div class="font-medium text-navy">{{ $passenger->full_name }}</div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4">
                        {{ $booking->flight->flight_number ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 capitalize">
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow/25 text-yellow-deep' }}">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $booking->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="" class="font-medium text-sky hover:underline">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-slate-400">No bookings found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection