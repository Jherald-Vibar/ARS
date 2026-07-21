@extends('layouts.staff_app')
@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <div class="mb-1 text-xs font-bold tracking-widest uppercase text-sky">Overview</div>
        <h1 class="text-3xl font-extrabold font-display text-navy">Staff Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="flex items-center p-6 space-x-4 bg-white border shadow-sm rounded-2xl border-slate-200">
                    <div class="bg-navy/8 p-3.5 rounded-xl">
                        <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.5 19l1.5-4.5L13 10l7-5-1.5 5.5L11 15l-3 7-1.5-4-4-1.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="mb-1 text-xs font-semibold tracking-wide uppercase text-slate-400">Total Flights</h3>
                        <p class="text-3xl font-extrabold font-display text-navy">{{ $totalFlights }}</p>
                    </div>
                </div>
                <div class="flex items-center p-6 space-x-4 bg-white border shadow-sm rounded-2xl border-slate-200">
                    <div class="bg-yellow/20 p-3.5 rounded-xl">
                        <svg class="w-6 h-6 text-yellow-deep" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17H5a2 2 0 01-2-2v-1.5a1.5 1.5 0 100-3V9a2 2 0 012-2h14a2 2 0 012 2v1.5a1.5 1.5 0 100 3V15a2 2 0 01-2 2H15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="mb-1 text-xs font-semibold tracking-wide uppercase text-slate-400">Total Bookings</h3>
                        <p class="text-3xl font-extrabold font-display text-navy">{{$totalBookings}}</p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white border shadow-sm rounded-2xl border-slate-200">
                <div class="flex items-center mb-4 space-x-3">
                    <div class="p-2 rounded-full bg-yellow/20">
                        <svg class="w-5 h-5 text-yellow-deep" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.5 0-3 1.5-3 3s1.5 3 3 3 3 1.5 3 3-1.5 3-3 3m0-12V4m0 16v-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold font-display text-navy">Total Revenue Per Day</h3>
                </div>
                <canvas id="revenueChart" height="150"></canvas>
            </div>
        </div>
        <div class="space-y-6">
            <div class="p-6 bg-white border shadow-sm rounded-2xl border-slate-200">
                <h3 class="mb-4 text-lg font-bold font-display text-navy">Recently Booked</h3>
                <div class="overflow-x-auto overflow-y-auto max-h-80">
                    <table class="w-full text-sm text-left text-slate-700">
                        <thead class="text-xs tracking-wide uppercase bg-slate-50 text-slate-500">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Booking ID</th>
                                <th class="px-4 py-3 font-semibold">Passenger</th>
                                <th class="px-4 py-3 font-semibold">Flight</th>
                                <th class="px-4 py-3 font-semibold">Date</th>
                                <th class="px-4 py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($bookings as $booking )
                            <tr class="transition hover:bg-slate-50/70">
                                <td class="px-4 py-3 text-slate-400">{{$booking->id}}</td>
                                <td class="px-4 py-3 font-medium text-navy">{{$booking->account->name}}</td>
                                <td class="px-4 py-3">{{$booking->flight->flight_number}}</td>
                                <td class="px-4 py-3 text-slate-500">{{$booking->booking_date}}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center bg-navy/5 text-navy text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{$booking->status}}
                                    </span>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-slate-400">
                                        No recent bookings.
                                    </td>
                                </tr>
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
            datasets: [{
                label: 'Revenue (₱)',
                data: {!! json_encode($totalAmount) !!},
                borderColor: '#000053',
                backgroundColor: 'rgba(0, 0, 83, 0.08)',
                pointBackgroundColor: '#fde047',
                pointBorderColor: '#000053',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection