@extends('layouts.passenger_app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-white py-12 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6 border border-gray-200">
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 text-sm p-3 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold text-center text-gray-800">Secure Payment</h2>
        <p class="text-center text-sm text-gray-500">Booking ID: {{ $booking->id }}</p>

        <div class="text-center text-lg font-semibold text-gray-700">
            Total Payable: <span class="text-blue-600">₱{{ number_format($amount, 2) }}</span>
        </div>

        <form action="{{ route('payment-stripe', ['bid' => $booking->id]) }}" method="POST" id="payment-form" class="space-y-6">
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
                <div id="card-element" class="w-full px-4 py-2 rounded-md border border-gray-300 bg-white shadow-sm"></div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300 shadow-md">
                Pay ${{ number_format($amount, 2) }}
            </button>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
</script>
@endsection
