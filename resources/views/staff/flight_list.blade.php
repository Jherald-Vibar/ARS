@extends('layouts.staff_app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-700">Flight List</h2>
    <!-- Add Button -->
        <button
            data-modal-target="addFlightModal"
            data-modal-toggle="addFlightModal"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
        >
            + Add Flight
        </button>
</div>

<!-- Flight List -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($flights as $flight)
    <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-semibold text-gray-800">{{ $flight->flight_number }}</h3>
            <span class="text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-700">{{ $flight->status }}</span>
        </div>
        <p class="text-sm text-gray-500">
            <strong>Route:</strong> {{ $flight->departureAirport->name }} → {{ $flight->arrivalAirport->name }}
        </p>
        <p class="text-sm text-gray-500">
            <strong>Departure:</strong> {{ $flight->departure_date }} {{ $flight->departure_time }}
        </p>
        <p class="text-sm text-gray-500">
            <strong>Arrival:</strong> {{ $flight->arrival_date }} {{ $flight->arrival_time }}
        </p>
        <p class="text-sm text-gray-500 mt-2">
            <strong>Prices:</strong>
            F: ₱{{ $flight->first_class_ticket_price }},
            B: ₱{{ $flight->business_class_ticket_price }},
            E: ₱{{ $flight->economy_class_ticket_price }}
        </p>
    </div>
    @endforeach
</div>

<!-- Create New Flight Modal -->
<div id="addFlightModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-3xl">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal Header -->
            <div class="flex items-center justify-between gap-2 p-4 border-b rounded-t">
                <img src="{{asset('web_images/image 1.png')}}" width="24px" alt='{{config('app.name')}}"Logo"'>
                <h3 class="text-lg font-semibold text-gray-900">
                    Create New Flight
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto"
                    data-modal-hide="addFlightModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <form action="" method="POST" class="p-6 space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Flight Number</label>
                        <input type="text" name="flight_number" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Aircraft</label>
                        <select name="aircraft_id" class="w-full px-3 py-2 border rounded-lg" required>
                            @foreach($aircrafts as $aircraft)
                                <option value="{{ $aircraft->id }}">{{ $aircraft->model }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Departure Airport</label>
                        <select name="departure_airport_id" class="w-full px-3 py-2 border rounded-lg" required>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->id }}">{{ $airport->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Arrival Airport</label>
                        <select name="arrival_airport_id" class="w-full px-3 py-2 border rounded-lg" required>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->id }}">{{ $airport->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Departure Date</label>
                        <input type="date" name="departure_date" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Departure Time</label>
                        <input type="time" name="departure_time" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Arrival Date</label>
                        <input type="date" name="arrival_date" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Arrival Time</label>
                        <input type="time" name="arrival_time" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">First Class (₱)</label>
                        <input type="number" name="first_class_ticket_price" step="0.01" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Business Class (₱)</label>
                        <input type="number" name="business_class_ticket_price" step="0.01" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Economy Class (₱)</label>
                        <input type="number" name="economy_class_ticket_price" step="0.01" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg">
                        <option value="Scheduled">Scheduled</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Delayed">Delayed</option>
                    </select>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Create Flight
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
