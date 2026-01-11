@extends('layouts.staff_app')
@section('content')
<h1 class="text-3xl font-bold text-gray-800">Staff Dashboard</h1>
<div class="grid grid-cols-1 lg:grid-cols-3 mt-2 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded-xl shadow border border-gray-100 flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.5 19l1.5-4.5L13 10l7-5-1.5 5.5L11 15l-3 7-1.5-4-4-1.5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-600 text-sm mb-1">Total Flights</h3>
                    <p class="text-3xl font-bold text-blue-700">{{ $totalFlights }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border border-gray-100 flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17H5a2 2 0 01-2-2v-1.5a1.5 1.5 0 100-3V9a2 2 0 012-2h14a2 2 0 012 2v1.5a1.5 1.5 0 100 3V15a2 2 0 01-2 2H15" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-600 text-sm mb-1">Total Bookings</h3>
                    <p class="text-3xl font-bold text-green-600">{{$totalBookings}}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
                <div class="bg-yellow-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.5 0-3 1.5-3 3s1.5 3 3 3 3 1.5 3 3-1.5 3-3 3m0-12V4m0 16v-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700">Total Revenue Per Day</h3>
            </div>
            <canvas id="revenueChart" height="150"></canvas>
        </div>
    </div>
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Recently Booked</h3>
            <div class="overflow-x-auto max-h-80 overflow-y-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2">Booking ID</th>
                            <th class="px-4 py-2">Passenger</th>
                            <th class="px-4 py-2">Flight</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($bookings as $booking )
                        <tr>
                            <td class="px-4 py-2">{{$booking->id}}</td>
                            <td class="px-4 py-2">{{$booking->account->name}}</td>
                            <td class="px-4 py-2">{{$booking->flight->flight_number}}</td>
                            <td class="px-4 py-2">{{$booking->booking_date}}</td>
                            <td class="px-4 py-2">{{$booking->status}}</td>

                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-400">
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
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1500, // 1.5s animation
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
