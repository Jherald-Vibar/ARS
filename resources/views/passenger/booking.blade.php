@extends('layouts.passenger_app')
@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- General Information -->
        <div class="md:col-span-2 bg-white rounded-2xl shadow-md border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-100 bg-[#E3E3E3]">
                <h2 class="text-xl font-semibold text-gray-800">General Information</h2>
            </div>
            <div class="px-8 py-6 space-y-5 bg-[#E3E3E3]">
                <form class="space-y-4">
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-600">Full Name</label>
                        <input type="text" id="fullName" value="{{$user->name}}" name="fullName" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-600">Address</label>
                        <input type="text" id="address" value="{{$user->address}}" name="address" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div>
                        <label for="passport" class="block text-sm font-medium text-gray-600">Passport Number</label>
                        <input type="text" id="passport" value="{{$user->passport_number}}" name="passport" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                        <input type="email" id="email" value="{{$user->email}}" name="email" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-600">Mobile</label>
                        <input type="text" id="mobile" value="{{$user->contact_number}}" name="mobile" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div>
                        <label for="passengers" class="block text-sm font-medium text-gray-600">No. of Passengers (Max: 3)</label>
                        <select id="passengers" name="passengers" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6 ">
            <!-- Flight Details -->
        @php
            preg_match('/\d+$/', $flight->flight_number, $numberMatch);
            $number = $numberMatch[0] ?? '';

            $lettersOnly = preg_replace('/\d+/', '', $flight->flight_number);
            $consonants = preg_replace('/[aeiou\s]/i', '', $lettersOnly);

            $flightNumber = strtoupper($consonants) . $number;
        @endphp

            <div class="bg-[#E3E3E3] rounded-2xl shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Flight Details</h2>
                </div>
                <div class="p-6 space-y-4 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <div>
                           <strong>{{ \Carbon\Carbon::parse($flight->departure_date)->format('M d, D') }}</strong><br />
                            {{$flight->departureAirport->name}}
                        </div>
                        <span>{{$flight->departure_time}}</span>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <strong>{{\Carbon\Carbon::parse($flight->arrival_date)->format('M d, D')}}</strong><br />
                            {{$flight->arrivalAirport->name}}
                        </div>
                        <span>{{$flight->arrival_time}}</span>
                    </div>
                </div>
            </div>

            <!-- Seat Prices -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100 bg-[#E3E3E3]">
                    <h2 class="text-lg font-semibold text-gray-800">Seat Prices</h2>
                </div>
                <div class="p-6 text-sm text-gray-700 space-y-3 bg-[#E3E3E3]">
                    <p><span class="font-semibold">First Class: </span>₱{{$flight->first_class_ticket_price}}</p>
                    <p><span class="font-semibold">Business: </span>₱{{$flight->business_class_ticket_price}}</p>
                    <p><span class="font-semibold">Economy: </span>₱{{$flight->economy_class_ticket_price}}</p>
                </div>
            </div>
        </div>
    </div>

    <!--Airplane-->
    <input type="hidden" id="selectedSeat" name="selectedSeat" value="">
    <input type="hidden" id="seatClass" name="seatClass" value="">

    <div class="mt-10 grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="flex justify-start mb-6">
                <div class="relative w-80 h-20 bg-gray-300 rounded-t-full mx-0">
                    <div class="absolute inset-x-0 -bottom-4 flex justify-center">
                        <span class="text-xs text-gray-700 font-semibold bg-white px-3 py-1 rounded-full shadow">
                            {{ $flight->aircraft->model }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto border-b">
                <div class="flex flex-col items-start space-y-1">
                    @php
                        $rows = $flight->aircraft->seat_capacity ?? 20;
                        $bookedSeats = $bookedSeat;
                        $firstClassLimit = ceil($rows / 5);
                        $businessClassLimit = ceil(($rows * 2) / 3);
                    @endphp

                    @for ($row = 1; $row <= $rows; $row++)
                        @php
                            if ($row <= $firstClassLimit) {
                                $seatClass = 'first';
                            } elseif ($row <= $businessClassLimit) {
                                $seatClass = 'business';
                            } else {
                                $seatClass = 'economy';
                            }

                            $showHeader = ($row == 1 || $row == $firstClassLimit + 1 || $row == $businessClassLimit + 1);
                        @endphp

                        @if ($showHeader)
                            <div class="w-80 my-3">
                                <h3 class="text-md text-center font-semibold text-gray-700 uppercase border-b pb-1">{{ $seatClass }}</h3>
                            </div>
                        @endif

                        <div class="flex items-center space-x-2">
                            @foreach (['A', 'B', 'C'] as $seat)
                                @php $seatId = $seat . $row; @endphp
                                <button
                                    type="button"
                                    class="seat-btn w-10 h-10 text-sm rounded font-medium text-center border
                                        {{ in_array($seatId, $bookedSeats)
                                            ? 'bg-red-400 text-white cursor-not-allowed'
                                            : 'bg-gray-100 hover:bg-blue-400 hover:text-white' }}"
                                    {{ in_array($seatId, $bookedSeats) ? 'disabled' : '' }}
                                    data-seat="{{ $seatId }}"
                                    data-class="{{ $seatClass }}">
                                    {{ $seatId }}
                                </button>
                            @endforeach

                            <div class="w-10"></div>

                            @foreach (['D', 'E', 'F'] as $seat)
                                @php $seatId = $seat . $row; @endphp
                                <button
                                    type="button"
                                    class="seat-btn w-10 h-10 text-sm rounded font-medium text-center border
                                        {{ in_array($seatId, $bookedSeats)
                                            ? 'bg-red-400 text-white cursor-not-allowed'
                                            : 'bg-gray-100 hover:bg-blue-400 hover:text-white' }}"
                                    {{ in_array($seatId, $bookedSeats) ? 'disabled' : '' }}
                                    data-seat="{{ $seatId }}"
                                    data-class="{{ $seatClass }}">
                                    {{ $seatId }}
                                </button>
                            @endforeach
                        </div>
                    @endfor
                </div>

                <div class="flex justify-start space-x-6 mt-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 bg-gray-100 border rounded"></div>
                        <span class="text-sm text-gray-600">Available</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 bg-blue-400 border rounded"></div>
                        <span class="text-sm text-gray-600">Selected</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 bg-red-400 border rounded"></div>
                        <span class="text-sm text-gray-600">Booked</span>
                    </div>
                </div>
            </div>
        </div>
         <div class="bg-[#E3E3E3] rounded-2xl shadow-md border border-gray-200 p-6 h-fit">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Summary</h2>
            <form method="POST" id="bookingForm" action="{{route('passenger-booking-store', ['fid' => $flight->id])}}" class="space-y-4">
                @csrf
                <div>
                    <label for="selectedSeatDisplay" class="block text-sm font-medium text-gray-600">Selected Seat</label>
                    <input type="text" id="selectedSeatDisplay" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg bg-gray-100" readonly>
                </div>

                <div>
                    <label for="selectedClassDisplay" class="block text-sm font-medium text-gray-600">Class</label>
                    <input type="text" id="selectedClassDisplay" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg bg-gray-100" readonly>
                </div>

                <input type="hidden" name="seat" id="seatInput">
                <input type="hidden" name="class" id="classInput">

                <div id="passengerCarousel" class="relative w-full max-w-md mx-auto border border-gray-300 rounded-xl shadow-lg bg-white p-6">
                    <div id="passengerForms" class="overflow-y-auto relative h-[430px] rounded-md bg-gray-50 shadow-inner p-6">

                    </div>
                    <button id="prevBtn"
                        class="absolute top-1/2 left-3 -translate-y-1/2 bg-white border border-gray-300 hover:bg-gray-100 text-gray-600 rounded-full w-10 h-10 flex items-center justify-center shadow-md transition"
                        aria-label="Previous passenger"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <button id="nextBtn"
                        class="absolute top-1/2 right-3 -translate-y-1/2 bg-white border border-gray-300 hover:bg-gray-100 text-gray-600 rounded-full w-10 h-10 flex items-center justify-center shadow-md transition"
                        aria-label="Next passenger"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <button
                    type="submit"
                    id="submitBookingBtn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200">
                    Create Booking
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

         @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                title: "Validation Error!",
                text: `{!! implode('<br>', $errors->all()) !!}`,
                icon: "error"
            });
        @endif
    });

document.addEventListener('DOMContentLoaded', () => {
    const maxPassengersSelect = document.getElementById('passengers');
    let maxSelectableSeats = parseInt(maxPassengersSelect.value);

    const selectedSeatInput = document.getElementById('selectedSeat');
    const seatClassInput = document.getElementById('seatClass');
    const selectedSeatDisplay = document.getElementById('selectedSeatDisplay');
    const selectedClassDisplay = document.getElementById('selectedClassDisplay');

    const seatButtons = document.querySelectorAll('.seat-btn:not([disabled])');
    const passengerFormContainer = document.getElementById('passengerForms');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let currentIndex = 0;
    let seats = [];

    maxPassengersSelect.addEventListener('change', () => {
        maxSelectableSeats = parseInt(maxPassengersSelect.value);
        resetSelection();
    });

    function resetSelection() {
        selectedSeats.forEach(btn => {
            btn.classList.remove('bg-blue-400', 'text-white');
            btn.classList.add('bg-gray-100', 'hover:bg-blue-400', 'hover:text-white');
        });

        selectedSeats = [];
        seats = [];
        currentIndex = 0;

        selectedSeatInput.value = '';
        seatClassInput.value = '';
        selectedSeatDisplay.value = '';
        selectedClassDisplay.value = '';
        passengerFormContainer.innerHTML = '';

        updateNavButtons();
    }

    let selectedSeats = [];

    seatButtons.forEach(seat => {
        seat.addEventListener('click', () => {
            const seatId = seat.dataset.seat;
            const seatClass = seat.dataset.class;

            const isSelected = seat.classList.contains('bg-blue-400');

            if (isSelected) {
                seat.classList.remove('bg-blue-400', 'text-white');
                seat.classList.add('bg-gray-100', 'hover:bg-blue-400', 'hover:text-white');
                selectedSeats = selectedSeats.filter(s => s !== seat);
            } else {
                if (selectedSeats.length >= maxSelectableSeats) {
                    alert(`You can only select up to ${maxSelectableSeats} seat(s).`);
                    return;
                }

                seat.classList.remove('bg-gray-100', 'hover:bg-blue-400', 'hover:text-white');
                seat.classList.add('bg-blue-400', 'text-white');
                selectedSeats.push(seat);
            }

            seats = selectedSeats.map(s => s.dataset.seat);
            const classList = selectedSeats.map(s => s.dataset.class);

            selectedSeatInput.value = seats.join(', ');
            seatClassInput.value = classList.join(', ');
            selectedSeatDisplay.value = seats.join(', ');
            selectedClassDisplay.value = classList.join(', ');

            currentIndex = 0;
            generatePassengerForms(seats);
            showSlide(currentIndex);
            updateNavButtons();
        });
    });

    function generatePassengerForms(seatList) {
    passengerFormContainer.innerHTML = '';
    seatList.forEach((seat, index) => {
        const seatClass = selectedSeats[index].dataset.class;
        const passengerFields = `
            <div class="passenger-slide absolute top-0 left-0 w-full h-full transition-opacity duration-500 rounded-md bg-white p-5 shadow-md flex flex-col gap-4"
                style="opacity: ${index === 0 ? 1 : 0}; pointer-events: ${index === 0 ? 'auto' : 'none'};">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">Passenger ${index + 1} (Seat ${seat})</h4>

                <input type="hidden" name="passengers[${index}][seat]" value="${seat}">

                <label class="text-sm font-medium text-gray-600">Full Name</label>
                <input type="text" name="passengers[${index}][name]" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <label class="text-sm font-medium text-gray-600">Contact Number</label>
                <input type="text" name="passengers[${index}][mobile_number]" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <label class="text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="passengers[${index}][email]" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <label class="text-sm font-medium text-gray-600">Passport Number</label>
                <input type="text" name="passengers[${index}][passport_number]" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <label class="text-sm font-medium text-gray-600">Seat Number</label>
                <input type="text" name="passengers[${index}][seat_number]" value="${seat}" readonly
                    class="w-full rounded-md border border-gray-300 px-4 py-2 bg-gray-100 cursor-not-allowed">

                <label class="text-sm font-medium text-gray-600">Seat Class</label>
                <input type="text" name="passengers[${index}][seat_class]" value="${seatClass}" readonly
                    class="w-full rounded-md border border-gray-300 px-4 py-2 bg-gray-100 cursor-not-allowed">
            </div>
        `;
        passengerFormContainer.insertAdjacentHTML('beforeend', passengerFields);
    });
    }
    function showSlide(index) {
        const slides = passengerFormContainer.querySelectorAll('.passenger-slide');
        slides.forEach((slide, i) => {
            slide.style.opacity = i === index ? '1' : '0';
            slide.style.pointerEvents = i === index ? 'auto' : 'none';
        });
        updateNavButtons();
    }
    function updateNavButtons() {
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === seats.length - 1 || seats.length === 0;

        prevBtn.classList.toggle('opacity-50', prevBtn.disabled);
        nextBtn.classList.toggle('opacity-50', nextBtn.disabled);
    }

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            showSlide(currentIndex);
        }
    });
    nextBtn.addEventListener('click', () => {
        if (currentIndex < seats.length - 1) {
            currentIndex++;
            showSlide(currentIndex);
        }
    });
    updateNavButtons();
});

  document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('submitBookingBtn').addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to proceed with booking?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, book it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('bookingForm').submit();
                }
            });
        });
    });
</script>
