@extends('layouts.passenger_app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 flex items-center justify-center px-4">
    <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg p-8 space-y-6">
        <h2 class="text-2xl font-bold text-center text-gray-800">Choose a payment method</h2>
        <p class="text-center text-sm text-gray-500">Choose a payment method below and fill out the following information.</p>
        <div class="grid grid-cols-2 border-b-2 border-gray text-center font-semibold ">
            <button id="tab-mobile" class="py-3 border-b-2 border-g text-blue-600 border-gray-600" onclick="switchTab('mobile')" type="button">
                Mobile
            </button>
            <button id="tab-card" class="py-3 text-gray-500 hover:text-blue-600" onclick="switchTab('card')" type="button">
                Credit / Debit Card
            </button>
        </div>
        <div id="section-mobile" class="space-y-6 ">
            <form id="mobile-payment-form" action="{{ route('paymongo.start', ['booking' => $booking->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <input type="hidden" name="mobile_method" id="mobile_method" value="">

                <div class="flex justify-center gap-6 py-4">
                    <img src="{{ asset('payment_img/GCASH.png') }}" alt="GCash" class="h-24 cursor-pointer hover:scale-105 transition"
                         onclick="selectMobileMethod('gcash')" id="img-gcash">
                </div>
                <div id="mobile-fields" class="space-y-4 hidden">
                    <label class="block text-sm font-medium text-gray-700" id="mobile-label"></label>
                    <input type="text" name="mobile_payment_input" id="mobile-payment-input" required
                           class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm" />
                </div>
                <p class="text-center text-sm mb-2">Click <strong>Proceed</strong> to pay with your mobile.</p>

                <div class="bg-[#D9D9D961] text-black text-sm p-4 rounded-md">
                    <strong>Note:</strong> If you choose this payment method, an additional fee of PHP 0.00 will be collected.
                    If you do not <br> agree with this fee, please select a different payment option.
                </div>
                <div class="pt-4">
                    <h3 class="text-xl font-semibold mb-2 text-center">Payment Details</h3>
                    <table class="w-full text-sm border border-gray-300 rounded-md">
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 font-medium">Booking Number</td>
                            <td class="px-4 py-2">{{ $booking->booking_reference }}</td>
                        </tr>
                        <tr class="border-b border-gray-200 bg-[#D9D9D961]">
                            <td class="px-4 py-2 font-medium">Amount</td>
                            <td class="px-4 py-2">₱{{ number_format($amount, 2) }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 font-medium">Convenience Fee</td>
                            <td class="px-4 py-2">₱0.00</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-bold bg-[#D9D9D961]">Total Amount Due</td>
                            <td class="px-4 py-2 font-bold bg-[#D9D9D961]">₱{{ number_format($amount, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded shadow">
                        Proceed
                    </button>
                    <a href="{{ url()->previous() }}"
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded shadow">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <div id="section-card" class="hidden space-y-6">
            <form action="{{ route('payment-stripe', ['bid' => $booking->id]) }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="amount" value="{{ $amount }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Holder Name</label>
                    <input type="text" name="card_holder_name" required
                           class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Details</label>
                    <div id="card-element" class="w-full px-4 py-2 rounded-md border border-gray-300 bg-white shadow-sm mb-4"></div>
                </div>

                <div class="bg-[#D9D9D961] text-black text-sm p-4 rounded-md">
                    <strong>Note:</strong> If you choose this payment method, an additional fee of PHP 0.00 will be collected.
                    If you do not <br> agree with this fee, please select a different payment option.
                </div>

                <!-- Payment Details Table -->
                <div>
                    <h3 class="text-xl font-semibold mt-4 text-center">Payment Details</h3>
                    <table class="w-full text-sm border border-gray-300 rounded-md mt-2">
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 font-medium">Booking Number</td>
                            <td class="px-4 py-2">{{ $booking->booking_reference }}</td>
                        </tr>
                        <tr class="border-b border-gray-200 bg-[#D9D9D961]">
                            <td class="px-4 py-2 font-medium">Amount</td>
                            <td class="px-4 py-2">₱{{ number_format($amount, 2) }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 font-medium">Convenience Fee</td>
                            <td class="px-4 py-2">₱0.00</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-bold bg-[#D9D9D961]">Total Amount Due</td>
                            <td class="px-4 py-2 font-bold bg-[#D9D9D961]">₱{{ number_format($amount, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow mt-4">
                    Pay ₱{{ number_format($amount, 2) }}
                </button>
            </form>
        </div>


    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: @json(session('success')),
        timer: 3000,
        showConfirmButton: false,
    });
    @endif
     @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: @json(session('error')),
        timer: 3000,
        showConfirmButton: false,
    });
    @endif
    function switchTab(tab) {
        const mobileTab = document.getElementById('tab-mobile');
        const cardTab = document.getElementById('tab-card');
        const mobileSection = document.getElementById('section-mobile');
        const cardSection = document.getElementById('section-card');

        if (tab === 'mobile') {
            mobileTab.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
            mobileTab.classList.remove('text-gray-500');
            cardTab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            cardTab.classList.add('text-gray-500');
            mobileSection.classList.remove('hidden');
            cardSection.classList.add('hidden');
        } else {
            cardTab.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
            cardTab.classList.remove('text-gray-500');
            mobileTab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            mobileTab.classList.add('text-gray-500');
            cardSection.classList.remove('hidden');
            mobileSection.classList.add('hidden');
        }
    }

    function selectMobileMethod(method) {
        ['gcash'].forEach(m => {
            const img = document.getElementById(`img-${m}`);
            if (m === method) {
                img.classList.add('ring-2', 'ring-blue-500', 'rounded-md');
            } else {
                img.classList.remove('ring-2', 'ring-blue-500', 'rounded-md');
            }
        });

        const label = document.getElementById('mobile-label');
        const inputContainer = document.getElementById('mobile-fields');
        const input = document.getElementById('mobile-payment-input');
        const mobileMethodInput = document.getElementById('mobile_method');

        input.value = '';
        inputContainer.classList.remove('hidden');
        mobileMethodInput.value = method;

        label.innerText = 'Enter GCash Number';
        input.setAttribute('placeholder', '09xxxxxxxxx');
        input.setAttribute('name', 'gcash_number');
        input.setAttribute('type', 'tel');
    }

    document.getElementById('mobile-payment-form').addEventListener('submit', function(e) {
        const method = document.getElementById('mobile_method').value;
        const input = document.getElementById('mobile-payment-input');

        if (!method) {
            e.preventDefault();
            alert('Please select a mobile payment method.');
            return;
        }

        if (!input.value.trim()) {
            e.preventDefault();
            alert('Please enter your GCash number.');
            input.focus();
        }
    });

    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();

    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                '::placeholder': { color: '#a0aec0' },
        },
        invalid: {
            color: '#e53e3e',
            iconColor: '#e53e3e',
        }
    }
});
card.mount('#card-element');

const form = document.getElementById('payment-form');
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const { error, paymentMethod } = await stripe.createPaymentMethod({
        type: 'card',
        card: card,
        billing_details: { name: form.card_holder_name.value }
    });

    if (error) {
        alert(error.message);
        return;
    }

    const { paymentIntent, error: confirmError } = await stripe.confirmCardPayment("{{ $clientSecret }}", {
        payment_method: paymentMethod.id
    });

    if (confirmError) {
        alert(confirmError.message);
    } else if (paymentIntent.status === 'succeeded') {
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_intent_id');
        hiddenInput.setAttribute('value', paymentIntent.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
});
</script>
@endsection
