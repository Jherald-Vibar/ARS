@extends('layouts.passenger_app')
@section('content')
<div class="max-w-6xl px-6 py-10 mx-auto">

    <div class="flex flex-col justify-between gap-4 mb-8 md:flex-row md:items-end">
        <div>
            <div class="mb-1 text-xs font-bold tracking-widest uppercase text-[#0ea5e9]">Booking</div>
            <h1 class="text-3xl font-extrabold font-display text-[#000053]">Reserve Your Seat</h1>
        </div>

        <!-- Step indicator: reflects the real order a passenger must complete -->
        <ol class="flex items-center gap-2 text-xs font-semibold text-slate-400">
            <li class="flex items-center gap-2">
                <span class="flex items-center justify-center w-6 h-6 text-white rounded-full bg-[#000053]">1</span>
                <span class="hidden text-[#000053] sm:inline">Your details</span>
            </li>
            <li class="w-6 border-t border-dashed border-slate-300"></li>
            <li class="flex items-center gap-2">
                <span class="flex items-center justify-center w-6 h-6 border-2 rounded-full border-slate-300">2</span>
                <span class="hidden sm:inline">Choose seat(s)</span>
            </li>
            <li class="w-6 border-t border-dashed border-slate-300"></li>
            <li class="flex items-center gap-2">
                <span class="flex items-center justify-center w-6 h-6 border-2 rounded-full border-slate-300">3</span>
                <span class="hidden sm:inline">Passenger info</span>
            </li>
        </ol>
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <!-- General Information -->
        <div class="bg-white border shadow-sm md:col-span-2 rounded-2xl border-slate-200">
            <div class="px-8 py-5 border-b border-slate-100">
                <h2 class="text-lg font-bold font-display text-[#000053]">General Information</h2>
                <p class="mt-0.5 text-xs text-slate-400">This is your booking contact — the person we'll reach if anything changes.</p>
            </div>
            <div class="px-8 py-6 space-y-5">
                <form class="space-y-4" id="contactForm">
                    <div>
                        <label for="fullName" class="block text-xs font-semibold tracking-wide uppercase text-slate-500">Full Name</label>
                        <input type="text" id="fullName" value="{{$user->name}}" name="fullName" required class="mt-1.5 w-full px-4 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#000053] rounded-lg outline-none transition" />
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-semibold tracking-wide uppercase text-slate-500">Address</label>
                        <input type="text" id="address" value="{{$user->address}}" name="address" required class="mt-1.5 w-full px-4 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#000053] rounded-lg outline-none transition" />
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="passport" class="block text-xs font-semibold tracking-wide uppercase text-slate-500">Passport Number</label>
                            <input type="text" id="passport" value="{{$user->passport_number}}" name="passport" required class="mt-1.5 w-full px-4 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#000053] rounded-lg outline-none transition" />
                        </div>
                        <div>
                            <label for="mobile" class="block text-xs font-semibold tracking-wide uppercase text-slate-500">Mobile</label>
                            <input type="text" id="mobile" value="{{$user->contact_number}}" name="mobile" required class="mt-1.5 w-full px-4 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#000053] rounded-lg outline-none transition" />
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold tracking-wide uppercase text-slate-500">Email</label>
                        <input type="email" id="email" value="{{$user->email}}" name="email" required class="mt-1.5 w-full px-4 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#000053] rounded-lg outline-none transition" />
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-semibold tracking-wide uppercase text-slate-500">No. of Passengers</label>
                        <div id="passengerCountGroup" class="inline-flex p-1 rounded-lg bg-slate-100" role="group" aria-label="Number of passengers">
                            <button type="button" data-count="1" class="px-5 py-2 text-sm font-semibold transition rounded-md passenger-count-btn">1</button>
                            <button type="button" data-count="2" class="px-5 py-2 text-sm font-semibold transition rounded-md passenger-count-btn">2</button>
                            <button type="button" data-count="3" class="px-5 py-2 text-sm font-semibold transition rounded-md passenger-count-btn">3</button>
                        </div>
                        <input type="hidden" id="passengers" value="1">
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Flight Details -->
            <div class="relative overflow-hidden text-white shadow-sm bg-[#000053] rounded-2xl">
                <div class="absolute inset-0 pointer-events-none opacity-60"
                     style="background: radial-gradient(ellipse 80% 60% at 100% 0%, rgba(30,64,175,0.4) 0%, transparent 70%);"></div>
                <div class="relative flex items-center justify-between px-6 py-4 border-b border-white/10">
                    <h2 class="text-lg font-bold font-display">Flight Details</h2>
                    <span class="text-xs font-semibold bg-[#facc15]/20 text-[#facc15] px-2.5 py-1 rounded-full">{{ $flight->flight_number }}</span>
                </div>
                <div class="relative p-6 text-sm text-white/80">
                    <div class="flex items-start justify-between">
                        <div>
                            <strong class="text-white">{{ \Carbon\Carbon::parse($flight->departure_date)->format('M d, D') }}</strong><br />
                            {{ $flight->departureAirport->name }}
                            <div class="mt-1 text-xs text-white/60">{{ $flight->departure_time }}</div>
                        </div>

                        <!-- route line: departure -> arrival -->
                        <div class="flex flex-col items-center px-3 pt-2 shrink-0">
                            <svg class="w-4 h-4 text-[#facc15]" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2.5 19l1.5-4.5L13 10l7-5-1.5 5.5L11 15l-3 7-1.5-4-4-1.5z"/>
                            </svg>
                            <div class="w-16 mt-1 border-t border-dashed border-white/30"></div>
                        </div>

                        <div class="text-right">
                            <strong class="text-white">{{ \Carbon\Carbon::parse($flight->arrival_date)->format('M d, D') }}</strong><br />
                            {{ $flight->arrivalAirport->name }}
                            <div class="mt-1 text-xs text-white/60">{{ $flight->arrival_time }}</div>
                        </div>
                    </div>
                    <div class="pt-4 mt-4 text-xs border-t border-white/10 text-white/60">
                        {{ $flight->aircraft->model }}
                    </div>
                </div>
            </div>

            <!-- Seat Prices -->
            <div class="bg-white border shadow-sm rounded-2xl border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-lg font-bold font-display text-[#000053]">Seat Prices</h2>
                </div>
                <div class="p-6 space-y-3 text-sm text-slate-700">
                    <p class="flex justify-between"><span class="font-semibold text-[#000053]">First Class</span> <span>₱{{ $flight->first_class_ticket_price }}</span></p>
                    <p class="flex justify-between"><span class="font-semibold text-[#000053]">Business</span> <span>₱{{ $flight->business_class_ticket_price }}</span></p>
                    <p class="flex justify-between"><span class="font-semibold text-[#000053]">Economy</span> <span>₱{{ $flight->economy_class_ticket_price }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 mt-10 md:grid-cols-3">
        <div class="md:col-span-2">
            @php
                $rows = $flight->aircraft->seat_capacity ?? 20;
                $bookedSeats = $bookedSeat;
                $firstClassLimit = ceil($rows / 5);
                $businessClassLimit = ceil(($rows * 2) / 3);
            @endphp

            <div class="relative max-w-sm mx-auto">
                <div class="absolute z-0 w-16 border top-40 -left-10 h-36 bg-slate-100 border-slate-200"
                     style="clip-path: polygon(100% 0%, 100% 100%, 0% 78%, 0% 22%);"></div>
                <div class="absolute z-0 w-16 border top-40 -right-10 h-36 bg-slate-100 border-slate-200"
                     style="clip-path: polygon(0% 0%, 0% 100%, 100% 78%, 100% 22%);"></div>

                <div class="relative z-10 bg-white border-2 border-slate-200 rounded-t-[3.5rem] rounded-b-[1.75rem] shadow-sm overflow-hidden">

                    <div class="relative pt-5 pb-4 overflow-hidden text-center bg-[#000053]">
                        <div class="absolute inset-0 pointer-events-none opacity-70"
                             style="background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(30,64,175,0.5) 0%, transparent 75%);"></div>
                        <svg class="relative mx-auto w-6 h-6 text-[#facc15] mb-1.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.5 19l1.5-4.5L13 10l7-5-1.5 5.5L11 15l-3 7-1.5-4-4-1.5z"/>
                        </svg>
                        <span class="relative text-xs font-semibold tracking-widest uppercase text-white/90">
                            {{ $flight->aircraft->model }}
                        </span>
                    </div>

                    <div class="flex items-center justify-center gap-1 px-6 pt-4 text-xs font-bold text-slate-400">
                        <span class="w-6"></span>
                        <div class="flex gap-2 w-[136px] justify-around">
                            <span>A</span><span>B</span><span>C</span>
                        </div>
                        <div class="w-10 text-center text-slate-300">|</div>
                        <div class="flex gap-2 w-[136px] justify-around">
                            <span>D</span><span>E</span><span>F</span>
                        </div>
                    </div>

                    <div class="max-h-[480px] overflow-y-auto px-6 pt-2 pb-4">
                        <div class="flex flex-col items-center space-y-2">
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
                                    <div class="w-full pt-3 pb-1">
                                        <h3 class="text-[11px] text-center font-bold text-[#0ea5e9] uppercase tracking-widest border-b border-slate-100 pb-2">{{ $seatClass }}</h3>
                                    </div>
                                @endif

                                <div class="flex items-center gap-1">
                                    <span class="w-6 text-[11px] text-slate-300 text-right">{{ $row }}</span>

                                    @foreach (['A', 'B', 'C'] as $seat)
                                        @php $seatId = $seat . $row; @endphp
                                        <button
                                            type="button"
                                            class="seat-btn w-10 h-10 text-sm rounded-t-lg rounded-b-md font-medium text-center border border-slate-200
                                                {{ in_array($seatId, $bookedSeats)
                                                    ? 'bg-red-400 text-white cursor-not-allowed border-red-400'
                                                    : 'bg-slate-50 hover:bg-[#000053] hover:text-white hover:border-[#000053] transition' }}"
                                            {{ in_array($seatId, $bookedSeats) ? 'disabled' : '' }}
                                            data-seat="{{ $seatId }}"
                                            data-class="{{ $seatClass }}">
                                            {{ $seatId }}
                                        </button>
                                    @endforeach

                                    <div class="flex justify-center w-10">
                                        <div class="w-px h-8 border-l border-dashed border-slate-200"></div>
                                    </div>

                                    @foreach (['D', 'E', 'F'] as $seat)
                                        @php $seatId = $seat . $row; @endphp
                                        <button
                                            type="button"
                                            class="seat-btn w-10 h-10 text-sm rounded-t-lg rounded-b-md font-medium text-center border border-slate-200
                                                {{ in_array($seatId, $bookedSeats)
                                                    ? 'bg-red-400 text-white cursor-not-allowed border-red-400'
                                                    : 'bg-slate-50 hover:bg-[#000053] hover:text-white hover:border-[#000053] transition' }}"
                                            {{ in_array($seatId, $bookedSeats) ? 'disabled' : '' }}
                                            data-seat="{{ $seatId }}"
                                            data-class="{{ $seatClass }}">
                                            {{ $seatId }}
                                        </button>
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="flex justify-center py-4 border-t bg-slate-50 border-slate-200">
                        <div class="w-14 h-7 bg-[#000053]" style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%);"></div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6 mt-6">
                <div class="flex items-center space-x-2">
                    <div class="w-5 h-5 border rounded bg-slate-50 border-slate-200"></div>
                    <span class="text-sm text-slate-500">Available</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-5 h-5 border rounded bg-[#000053] border-[#000053]"></div>
                    <span class="text-sm text-slate-500">Selected</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-5 h-5 bg-red-400 border border-red-400 rounded"></div>
                    <span class="text-sm text-slate-500">Booked</span>
                </div>
                <div class="px-3 py-1 text-xs font-semibold rounded-full text-[#0ea5e9] bg-[#0ea5e9]/10" id="seatCounter">
                    0 of 1 seat selected
                </div>
            </div>
        </div>

        <!-- Booking Summary: styled like a boarding-pass stub -->
        <div class="relative h-fit">
            <div class="relative overflow-hidden bg-white border shadow-sm rounded-2xl border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-lg font-bold font-display text-[#000053]">Booking Summary</h2>
                </div>

                <form method="POST" id="bookingForm" action="{{ route('passenger-booking-store', ['fid' => $flight->id]) }}">
                    @csrf

                    <div class="grid grid-cols-2 gap-3 px-6 pt-5">
                        <div>
                            <label class="block text-xs font-semibold tracking-wide uppercase text-slate-500">Seat(s)</label>
                            <input type="text" id="selectedSeatDisplay" class="w-full px-3 py-2 mt-1.5 text-sm border border-slate-200 rounded-lg bg-slate-50" readonly placeholder="—">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold tracking-wide uppercase text-slate-500">Class</label>
                            <input type="text" id="selectedClassDisplay" class="w-full px-3 py-2 mt-1.5 text-sm border border-slate-200 rounded-lg bg-slate-50 capitalize" readonly placeholder="—">
                        </div>
                    </div>

                    <input type="hidden" name="seat" id="seatInput">
                    <input type="hidden" name="class" id="classInput">
                    <div id="hiddenSeatInputs"></div>

                    <!-- perforated tear line -->
                    <div class="relative my-5">
                        <div class="absolute left-0 w-4 h-4 -mt-2 -translate-x-1/2 rounded-full bg-slate-100"></div>
                        <div class="border-t border-dashed border-slate-300"></div>
                        <div class="absolute right-0 w-4 h-4 -mt-2 translate-x-1/2 rounded-full bg-slate-100"></div>
                    </div>

                    <div class="px-6 pb-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-bold text-[#000053]">Passenger Details</h3>
                            <div id="passengerDots" class="flex gap-1.5"></div>
                        </div>

                        <div id="passengerCarousel" class="relative">
                            <div id="passengerForms" class="relative h-[420px] overflow-y-auto rounded-lg bg-slate-50 shadow-inner p-5">
                                <p id="emptyPassengerState" class="flex items-center justify-center h-full px-4 text-sm text-center text-slate-400">
                                    Select your seat(s) on the map to add passenger details.
                                </p>
                            </div>

                            <button type="button" id="prevBtn"
                                class="absolute flex items-center justify-center w-9 h-9 transition -translate-y-1/2 bg-white border rounded-full shadow-md top-1/2 -left-3 border-slate-200 hover:bg-[#000053] hover:text-white hover:border-[#000053] text-slate-500 disabled:opacity-40 disabled:pointer-events-none"
                                aria-label="Previous passenger">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <button type="button" id="nextBtn"
                                class="absolute flex items-center justify-center w-9 h-9 transition -translate-y-1/2 bg-white border rounded-full shadow-md top-1/2 -right-3 border-slate-200 hover:bg-[#000053] hover:text-white hover:border-[#000053] text-slate-500 disabled:opacity-40 disabled:pointer-events-none"
                                aria-label="Next passenger">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <button
                            type="submit"
                            id="submitBookingBtn"
                            disabled
                            class="w-full px-4 py-3 mt-5 text-sm font-bold rounded-lg font-display transition-all duration-200 border
                                   text-white bg-[#000053] border-[#000053] hover:bg-[#14144a]
                                   disabled:bg-slate-200 disabled:text-slate-400 disabled:border-slate-200 disabled:cursor-not-allowed disabled:hover:bg-slate-200">
                            Confirm Booking
                        </button>
                        <p id="submitHint" class="mt-2 text-xs text-center text-slate-400">Select 1 seat and complete passenger details to continue.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Swal.fire({ title: 'Success!', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#000053', confirmButtonText: 'OK' });
    @endif
    @if(session('error'))
        Swal.fire({ title: 'Error!', text: "{{ session('error') }}", icon: 'error', confirmButtonColor: '#000053', confirmButtonText: 'OK' });
    @endif
    @if ($errors->any())
        Swal.fire({ title: "Validation Error!", text: `{!! implode('<br>', $errors->all()) !!}`, icon: "error", confirmButtonColor: '#000053' });
    @endif
});

document.addEventListener('DOMContentLoaded', () => {
    // ---------- Elements ----------
    const passengerCountBtns = document.querySelectorAll('.passenger-count-btn');
    const passengersHidden   = document.getElementById('passengers');

    const seatButtons        = document.querySelectorAll('.seat-btn:not([disabled])');
    const seatCounter        = document.getElementById('seatCounter');

    const selectedSeatDisplay  = document.getElementById('selectedSeatDisplay');
    const selectedClassDisplay = document.getElementById('selectedClassDisplay');
    const seatInput            = document.getElementById('seatInput');
    const classInput           = document.getElementById('classInput');
    const hiddenSeatInputs     = document.getElementById('hiddenSeatInputs');

    const passengerFormContainer = document.getElementById('passengerForms');
    const emptyPassengerState    = document.getElementById('emptyPassengerState');
    const passengerDots          = document.getElementById('passengerDots');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    const submitBtn  = document.getElementById('submitBookingBtn');
    const submitHint = document.getElementById('submitHint');

    // ---------- State ----------
    // seats: ordered array of seat ids currently selected, e.g. ['A1','D3']
    // seatClassMap: seatId -> class ('first' | 'business' | 'economy')
    // passengerData: seatId -> { name, mobile_number, email, passport_number } — persists
    //                across re-renders so switching seats never wipes what's typed.
    let maxSelectableSeats = 1;
    let seats = [];
    const seatClassMap = {};
    const passengerData = {};
    let currentIndex = 0;

    // ---------- Passenger count segmented control ----------
    function setPassengerCount(count) {
        maxSelectableSeats = count;
        passengersHidden.value = count;

        passengerCountBtns.forEach(btn => {
            const active = parseInt(btn.dataset.count) === count;
            btn.classList.toggle('bg-[#000053]', active);
            btn.classList.toggle('text-white', active);
            btn.classList.toggle('text-slate-500', !active);
        });

        // If the new max is smaller than what's selected, trim from the end
        // and let the person know, rather than silently discarding it.
        if (seats.length > maxSelectableSeats) {
            const removed = seats.splice(maxSelectableSeats);
            removed.forEach(seatId => {
                const btn = document.querySelector(`.seat-btn[data-seat="${seatId}"]`);
                if (btn) deselectSeatButton(btn);
            });
            Swal.fire({
                title: 'Seat selection updated',
                text: `You selected ${count} passenger(s), so the extra seat(s) were deselected.`,
                icon: 'info',
                confirmButtonColor: '#000053'
            });
        }

        refreshSummary();
    }

    passengerCountBtns.forEach(btn => {
        btn.addEventListener('click', () => setPassengerCount(parseInt(btn.dataset.count)));
    });
    setPassengerCount(1);

    // ---------- Seat selection ----------
    function deselectSeatButton(btn) {
        btn.classList.remove('bg-[#000053]', 'text-white', 'border-[#000053]');
        btn.classList.add('bg-slate-50', 'hover:bg-[#000053]', 'hover:text-white', 'hover:border-[#000053]');
    }

    seatButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const seatId = btn.dataset.seat;
            const seatClass = btn.dataset.class;
            const alreadySelected = seats.includes(seatId);

            if (alreadySelected) {
                deselectSeatButton(btn);
                seats = seats.filter(s => s !== seatId);
            } else {
                if (seats.length >= maxSelectableSeats) {
                    Swal.fire({
                        title: 'Seat limit reached',
                        text: `You can only select up to ${maxSelectableSeats} seat(s). Increase "No. of Passengers" to select more.`,
                        icon: 'warning',
                        confirmButtonColor: '#000053'
                    });
                    return;
                }
                btn.classList.remove('bg-slate-50', 'hover:bg-[#000053]', 'hover:text-white', 'hover:border-[#000053]');
                btn.classList.add('bg-[#000053]', 'text-white', 'border-[#000053]');
                seats.push(seatId);
                seatClassMap[seatId] = seatClass;
                // Jump to the newly added passenger's slide.
                currentIndex = seats.length - 1;
            }

            refreshSummary();
        });
    });

    // ---------- Keep summary + passenger forms in sync with `seats` ----------
    function refreshSummary() {
        const classList = seats.map(s => seatClassMap[s]);
        selectedSeatDisplay.value  = seats.join(', ');
        selectedClassDisplay.value = classList.join(', ');
        seatInput.value  = seats.join(', ');
        classInput.value = classList.join(', ');

        seatCounter.textContent = `${seats.length} of ${maxSelectableSeats} seat${maxSelectableSeats > 1 ? 's' : ''} selected`;

        renderPassengerForms();
        updateSubmitState();
    }

    function fieldsFor(seatId) {
        return passengerData[seatId] || (passengerData[seatId] = { name: '', mobile_number: '', email: '', passport_number: '' });
    }

    function renderPassengerForms() {
        if (currentIndex > seats.length - 1) currentIndex = Math.max(0, seats.length - 1);

        passengerFormContainer.innerHTML = '';
        hiddenSeatInputs.innerHTML = '';

        if (seats.length === 0) {
            passengerFormContainer.appendChild(emptyPassengerState);
            passengerDots.innerHTML = '';
            updateNavButtons();
            return;
        }

        seats.forEach((seatId, index) => {
            const seatClass = seatClassMap[seatId];
            const data = fieldsFor(seatId);

            const slide = document.createElement('div');
            slide.className = 'absolute inset-0 flex flex-col gap-3 p-5 transition-opacity duration-300 bg-white border rounded-lg shadow-sm passenger-slide border-slate-100';
            slide.style.opacity = index === currentIndex ? '1' : '0';
            slide.style.pointerEvents = index === currentIndex ? 'auto' : 'none';

            slide.innerHTML = `
                <h4 class="mb-1 text-base font-bold font-display text-[#000053]">Passenger ${index + 1} <span class="font-normal text-slate-400">· Seat ${seatId} (${seatClass})</span></h4>

                ${index === 0 ? `
                <label class="flex items-center gap-2 pb-1 text-xs font-medium text-slate-500">
                    <input type="checkbox" id="sameAsContact" class="rounded text-[#000053] focus:ring-[#000053]">
                    Same as booking contact
                </label>` : ''}

                <label class="text-xs font-semibold tracking-wide uppercase text-slate-500">Full Name</label>
                <input type="text" data-seat="${seatId}" data-field="name" value="${data.name}" required
                    class="w-full rounded-lg border border-slate-200 bg-white focus:border-[#000053] px-4 py-2.5 outline-none transition">

                <label class="text-xs font-semibold tracking-wide uppercase text-slate-500">Contact Number</label>
                <input type="text" data-seat="${seatId}" data-field="mobile_number" value="${data.mobile_number}" required
                    class="w-full rounded-lg border border-slate-200 bg-white focus:border-[#000053] px-4 py-2.5 outline-none transition">

                <label class="text-xs font-semibold tracking-wide uppercase text-slate-500">Email</label>
                <input type="email" data-seat="${seatId}" data-field="email" value="${data.email}" required
                    class="w-full rounded-lg border border-slate-200 bg-white focus:border-[#000053] px-4 py-2.5 outline-none transition">

                <label class="text-xs font-semibold tracking-wide uppercase text-slate-500">Passport Number</label>
                <input type="text" data-seat="${seatId}" data-field="passport_number" value="${data.passport_number}" required
                    class="w-full rounded-lg border border-slate-200 bg-white focus:border-[#000053] px-4 py-2.5 outline-none transition">
            `;
            passengerFormContainer.appendChild(slide);

            // Hidden inputs submitted with the form (index-based, as the backend expects).
            hiddenSeatInputs.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="passengers[${index}][seat]" value="${seatId}">
                <input type="hidden" name="passengers[${index}][seat_number]" value="${seatId}">
                <input type="hidden" name="passengers[${index}][seat_class]" value="${seatClass}">
                <input type="hidden" name="passengers[${index}][name]" value="${data.name}">
                <input type="hidden" name="passengers[${index}][mobile_number]" value="${data.mobile_number}">
                <input type="hidden" name="passengers[${index}][email]" value="${data.email}">
                <input type="hidden" name="passengers[${index}][passport_number]" value="${data.passport_number}">
            `);
        });

        renderDots();
        updateNavButtons();
        wireSameAsContact();
    }

    // Keep visible inputs and the hidden submit-mirrors in lockstep, and persist
    // to passengerData so nothing is lost if the person reselects seats.
    passengerFormContainer.addEventListener('input', (e) => {
        const seatId = e.target.dataset.seat;
        const field  = e.target.dataset.field;
        if (!seatId || !field) return;

        fieldsFor(seatId)[field] = e.target.value;

        const index = seats.indexOf(seatId);
        const mirror = hiddenSeatInputs.querySelector(`input[name="passengers[${index}][${field}]"]`);
        if (mirror) mirror.value = e.target.value;

        updateSubmitState();
    });

    function wireSameAsContact() {
        const checkbox = document.getElementById('sameAsContact');
        if (!checkbox || seats.length === 0) return;
        const seatId = seats[0];

        const applyContactInfo = () => {
            const data = fieldsFor(seatId);
            data.name           = document.getElementById('fullName').value;
            data.mobile_number  = document.getElementById('mobile').value;
            data.email          = document.getElementById('email').value;
            data.passport_number = document.getElementById('passport').value;
            renderPassengerForms();
            updateSubmitState();
        };

        checkbox.addEventListener('change', () => {
            if (checkbox.checked) applyContactInfo();
        });
    }

    // ---------- Carousel ----------
    function renderDots() {
        passengerDots.innerHTML = seats.map((_, i) =>
            `<span class="w-1.5 h-1.5 rounded-full ${i === currentIndex ? 'bg-[#000053]' : 'bg-slate-300'}"></span>`
        ).join('');
    }

    function showSlide(index) {
        currentIndex = index;
        const slides = passengerFormContainer.querySelectorAll('.passenger-slide');
        slides.forEach((slide, i) => {
            slide.style.opacity = i === index ? '1' : '0';
            slide.style.pointerEvents = i === index ? 'auto' : 'none';
        });
        renderDots();
        updateNavButtons();
    }

    function updateNavButtons() {
        prevBtn.disabled = currentIndex === 0 || seats.length === 0;
        nextBtn.disabled = currentIndex >= seats.length - 1 || seats.length === 0;
    }

    prevBtn.addEventListener('click', () => { if (currentIndex > 0) showSlide(currentIndex - 1); });
    nextBtn.addEventListener('click', () => { if (currentIndex < seats.length - 1) showSlide(currentIndex + 1); });

    // ---------- Submit gating ----------
    function updateSubmitState() {
        const seatsComplete = seats.length === maxSelectableSeats && seats.length > 0;
        const passengersComplete = seats.every(seatId => {
            const d = fieldsFor(seatId);
            return d.name && d.mobile_number && d.email && d.passport_number;
        });

        const ready = seatsComplete && passengersComplete;
        submitBtn.disabled = !ready;

        if (seats.length < maxSelectableSeats) {
            submitHint.textContent = `Select ${maxSelectableSeats - seats.length} more seat(s) on the map.`;
        } else if (!passengersComplete) {
            submitHint.textContent = `Fill in every passenger's details to continue.`;
        } else {
            submitHint.textContent = `Everything looks good — review and confirm below.`;
        }
    }

    refreshSummary();

    // ---------- Confirm dialog ----------
    document.getElementById('submitBookingBtn').addEventListener('click', function (event) {
        event.preventDefault();
        if (this.disabled) return;

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to proceed with booking?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000053',
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