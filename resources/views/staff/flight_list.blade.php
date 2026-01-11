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


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($flights as $flight)
        @php
            preg_match('/\d+$/', $flight->flight_number, $numberMatch);
            $number = $numberMatch[0] ?? '';

            $lettersOnly = preg_replace('/\d+/', '', $flight->flight_number);
            $consonants = preg_replace('/[aeiou\s]/i', '', $lettersOnly);

            $flightNumber = strtoupper($consonants) . $number;
        @endphp

        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 transition transform hover:scale-[1.01] hover:shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M2.5 19l6.5-6.5m0 0l6.5-6.5m-6.5 6.5h13" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $flightNumber }}</h3>
                </div>
                <span class="text-xs font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                    {{ ucfirst($flight->status) }}
                </span>
            </div>

            <div class="text-sm text-gray-600 space-y-1">
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M17.657 16.657L13.414 12l4.243-4.243m0 0L12 2.343m5.657 5.414L12 12m0 0L6.343 6.343m5.657 5.657L2.343 12m5.414 5.657L12 12m0 0l4.243 4.243" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <strong>Route:</strong> {{ $flight->departureAirport->name }} → {{ $flight->arrivalAirport->name }}
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <strong>Departure:</strong> {{ $flight->departure_date }} @ {{ \Carbon\Carbon::parse($flight->departure_time)->format('h:i A') }}
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <strong>Arrival:</strong> {{ $flight->arrival_date }} @ {{ \Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') }}
                </p>
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 01.894.553l2.447 4.95 5.467.796a1 1 0 01.554 1.706l-3.956 3.857.934 5.447a1 1 0 01-1.451 1.054L10 17.75l-4.889 2.573a1 1 0 01-1.451-1.054l.934-5.447-3.956-3.857a1 1 0 01.554-1.706l5.467-.796L9.106 2.553A1 1 0 0110 2z"/>
                    </svg>
                    <strong>Prices:</strong>
                    F: ₱{{ number_format($flight->first_class_ticket_price) }},
                    B: ₱{{ number_format($flight->business_class_ticket_price) }},
                    E: ₱{{ number_format($flight->economy_class_ticket_price) }}
                </p>
            </div>

            <div class="absolute bottom-4 right-4 flex space-x-2">
                <!-- Edit Button -->
                <button data-modal-target="editFlightModal-{{ $flight->id }}" data-modal-toggle="editFlightModal-{{ $flight->id }}"
                    class=" hover:bg-yellow-500 text-gray-700 p-2 rounded-full shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.586-6.586a2 2 0 012.828 0l.172.172a2 2 0 010 2.828L12 15H9v-3z" />
                    </svg>
                </button>

                <!-- Delete Button -->
                <form action="{{ route('staff-flights-delete', $flight->id) }}" method="POST" class="delete-form" data-flight="{{ $flightNumber }}>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn text-gray-700 hover:bg-red-600 text-black p-2 rounded-full shadow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @endforeach

    @foreach($flights as $flight)
<!-- Edit Flight Modal -->
<div id="editFlightModal-{{ $flight->id }}" tabindex="-1" aria-hidden="true"
    class="hidden fixed top-0 right-0 left-0 z-50 w-full inset-0 h-full bg-black bg-opacity-50 flex items-center justify-center">
    <div class="relative p-4 w-full max-w-3xl">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Edit Flight: {{ $flight->flight_number }}
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-900 rounded-lg text-sm p-1.5"
                    data-modal-hide="editFlightModal-{{ $flight->id }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('staff-flights-update', $flight->id) }}" method="POST" class="p-6 space-y-4 edit-flight-form">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Aircraft</label>
                        <select name="aircraft_id" class="w-full px-3 py-2 border rounded-lg" required>
                            @foreach($aircrafts as $aircraft)
                                <option value="{{ $aircraft->id }}" {{ $flight->aircraft_id == $aircraft->id ? 'selected' : '' }}>
                                    {{ $aircraft->model }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Departure Airport</label>
                        <select name="departure_airport_id" class="w-full px-3 py-2 border rounded-lg" required>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->id }}" {{ $flight->departure_airport_id == $airport->id ? 'selected' : '' }}>
                                    {{ $airport->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Arrival Airport</label>
                        <select name="arrival_airport_id" class="w-full px-3 py-2 border rounded-lg" required>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->id }}" {{ $flight->arrival_airport_id == $airport->id ? 'selected' : '' }}>
                                    {{ $airport->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Departure Date</label>
                        <input type="date" name="departure_date" value="{{ $flight->departure_date }}" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Departure Time</label>
                        <input type="time" name="departure_time" value="{{ $flight->departure_time }}" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Arrival Date</label>
                        <input type="date" name="arrival_date" value="{{ $flight->arrival_date }}" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Arrival Time</label>
                        <input type="time" name="arrival_time" value="{{ $flight->arrival_time }}" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">First Class (₱)</label>
                        <input type="number" name="first_class_ticket_price" step="0.01" value="{{ $flight->first_class_ticket_price }}" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Business Class (₱)</label>
                        <input type="number" name="business_class_ticket_price" step="0.01" value="{{ $flight->business_class_ticket_price }}" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Economy Class (₱)</label>
                        <input type="number" name="economy_class_ticket_price" step="0.01" value="{{ $flight->economy_class_ticket_price }}" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg">
                        <option value="Scheduled" {{ $flight->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Cancelled" {{ $flight->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Delayed" {{ $flight->status == 'Delayed' ? 'selected' : '' }}>Delayed</option>
                    </select>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                        Update Flight
                    </button>
                </div>
            </form>
        </div>
    </div>
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

            <form action="{{route('staff-flights-store')}}" method="POST" class="add-flight-form p-6 space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Show success message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
        });
    @endif

    document.querySelector('.add-flight-form')?.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Create New Flight?',
            text: "Please confirm you want to add this flight.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#2563eb', // blue
            cancelButtonColor: '#6b7280', // gray
            confirmButtonText: 'Yes, create it',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    });

    document.querySelectorAll('.edit-flight-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Update Flight?',
                text: "Are you sure you want to save these changes?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b', // yellow
                cancelButtonColor: '#6b7280', // gray
                confirmButtonText: 'Yes, update it',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Confirm delete
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const flight = form.getAttribute('data-flight');

            Swal.fire({
                title: `Delete Flight ${flight}?`,
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>







@endsection
