@extends('layouts.staff_app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">All Bookings</h2>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Passenger(s)</th>
                    <th class="px-6 py-3">Flight</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Booked At</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bookings as $booking)
                <tr>
                    <td class="px-6 py-4">{{ $booking->id }}</td>
                    <td class="px-6 py-4">
                        @foreach($booking->passengers as $passenger)
                            <div>{{ $passenger->full_name }}</div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4">
                        {{ $booking->flight->flight_number ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 capitalize">
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $booking->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="" class="text-blue-600 hover:underline">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">No bookings found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
