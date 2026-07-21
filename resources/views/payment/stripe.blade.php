@extends('layouts.passenger_app')

@section('content')
<div class="flex items-center justify-center min-h-screen px-4 py-10 bg-slate-100">
    <div class="w-full max-w-2xl overflow-hidden bg-white border shadow-sm rounded-2xl border-slate-200">

        <div class="px-8 pt-8 pb-6 text-center border-b border-slate-100">
            <div class="mb-1 text-xs font-bold tracking-widest uppercase text-[#0ea5e9]">Payment</div>
            <h2 class="text-2xl font-bold font-display text-[#000053]">Choose a Payment Method</h2>
            <p class="mt-1 text-sm text-slate-500">Booking <span class="font-semibold text-[#000053]">{{ $booking->booking_reference }}</span> · ₱{{ number_format($amount, 2) }} due</p>
        </div>

        <div class="px-8 pt-6">
            <div id="paymentTabGroup" class="inline-flex w-full p-1 rounded-lg bg-slate-100" role="tablist">
                <button id="tab-mobile" type="button" role="tab" aria-selected="true"
                        class="payment-tab flex-1 py-2.5 text-sm font-semibold rounded-md transition"
                        onclick="switchTab('mobile')">
                    Mobile (GCash)
                </button>
                <button id="tab-card" type="button" role="tab" aria-selected="false"
                        class="payment-tab flex-1 py-2.5 text-sm font-semibold rounded-md transition"
                        onclick="switchTab('card')">
                    Credit / Debit Card
                </button>
            </div>
        </div>

        <!-- ================= MOBILE / GCASH ================= -->
        <div id="section-mobile" class="px-8 pt-6 pb-8 space-y-6">
            <form id="mobile-payment-form" action="{{ route('paymongo.start', ['booking' => $booking->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <input type="hidden" name="mobile_method" id="mobile_method" value="">

                <button type="button" id="img-gcash" onclick="selectMobileMethod('gcash')"
                        class="flex items-center justify-center w-full gap-3 p-4 transition border-2 rounded-xl border-slate-200 hover:border-[#000053]/40">
                    <img src="{{ asset('payment_img/GCASH.png') }}" alt="GCash" class="h-10">
                    <span class="text-sm font-semibold text-slate-600">Pay with GCash</span>
                </button>

                <div id="mobile-fields" class="hidden space-y-1.5">
                    <label class="block text-xs font-semibold tracking-wide uppercase text-slate-500" id="mobile-label">Enter GCash Number</label>
                    <input type="tel" name="gcash_number" id="mobile-payment-input" required
                           placeholder="09xxxxxxxxx" maxlength="11"
                           class="w-full px-4 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#000053] rounded-lg outline-none transition" />
                    <p class="text-xs text-slate-400">11 digits, starting with 09.</p>
                </div>

                <div class="flex gap-3 p-4 text-sm border-l-4 rounded-lg bg-slate-50 border-[#0ea5e9] text-slate-600">
                    <svg class="w-5 h-5 mt-0.5 shrink-0 text-[#0ea5e9]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    <p>An additional fee of <strong>₱0.00</strong> applies to this method. If you'd rather avoid it, choose a different payment option.</p>
                </div>

                <div>
                    <h3 class="mb-3 text-sm font-bold text-[#000053]">Payment Details</h3>
                    <div class="overflow-hidden text-sm border rounded-lg border-slate-200">
                        <div class="flex justify-between px-4 py-2.5"><span class="text-slate-500">Booking Number</span><span class="font-medium text-[#000053]">{{ $booking->booking_reference }}</span></div>
                        <div class="flex justify-between px-4 py-2.5 bg-slate-50"><span class="text-slate-500">Amount</span><span class="font-medium text-[#000053]">₱{{ number_format($amount, 2) }}</span></div>
                        <div class="flex justify-between px-4 py-2.5"><span class="text-slate-500">Convenience Fee</span><span class="font-medium text-[#000053]">₱0.00</span></div>
                        <div class="flex justify-between px-4 py-3 border-t border-slate-200 bg-slate-50"><span class="font-bold text-[#000053]">Total Amount Due</span><span class="font-bold text-[#000053]">₱{{ number_format($amount, 2) }}</span></div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ url()->previous() }}"
                       class="px-6 py-2.5 text-sm font-semibold rounded-lg text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Cancel
                    </a>
                    <button type="submit" id="mobile-submit-btn"
                            class="px-6 py-2.5 text-sm font-bold text-white transition rounded-lg font-display bg-[#000053] hover:bg-[#14144a] disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="btn-label">Proceed</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ================= CARD ================= -->
        <div id="section-card" class="hidden px-8 pt-6 pb-8 space-y-6">
            <form action="{{ route('payment-stripe', ['bid' => $booking->id]) }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="amount" value="{{ $amount }}">

                <div>
                    <label class="block mb-1.5 text-xs font-semibold tracking-wide uppercase text-slate-500">Card Holder Name</label>
                    <input type="text" name="card_holder_name" required
                           class="w-full px-4 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-[#000053] rounded-lg outline-none transition" />
                </div>

                <div>
                    <label class="block mb-1.5 text-xs font-semibold tracking-wide uppercase text-slate-500">Card Details</label>
                    <div id="card-element" class="w-full px-4 py-3 border rounded-lg border-slate-200 bg-slate-50"></div>
                    <p id="card-errors" class="mt-1.5 text-xs text-red-500"></p>
                </div>

                <div class="flex gap-3 p-4 text-sm border-l-4 rounded-lg bg-slate-50 border-[#0ea5e9] text-slate-600">
                    <svg class="w-5 h-5 mt-0.5 shrink-0 text-[#0ea5e9]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    <p>An additional fee of <strong>₱0.00</strong> applies to this method. If you'd rather avoid it, choose a different payment option.</p>
                </div>

                <div>
                    <h3 class="mb-3 text-sm font-bold text-[#000053]">Payment Details</h3>
                    <div class="overflow-hidden text-sm border rounded-lg border-slate-200">
                        <div class="flex justify-between px-4 py-2.5"><span class="text-slate-500">Booking Number</span><span class="font-medium text-[#000053]">{{ $booking->booking_reference }}</span></div>
                        <div class="flex justify-between px-4 py-2.5 bg-slate-50"><span class="text-slate-500">Amount</span><span class="font-medium text-[#000053]">₱{{ number_format($amount, 2) }}</span></div>
                        <div class="flex justify-between px-4 py-2.5"><span class="text-slate-500">Convenience Fee</span><span class="font-medium text-[#000053]">₱0.00</span></div>
                        <div class="flex justify-between px-4 py-3 border-t border-slate-200 bg-slate-50"><span class="font-bold text-[#000053]">Total Amount Due</span><span class="font-bold text-[#000053]">₱{{ number_format($amount, 2) }}</span></div>
                    </div>
                </div>

                <button type="submit" id="card-submit-btn"
                        class="w-full px-4 py-3 text-sm font-bold text-white transition rounded-lg font-display bg-[#000053] hover:bg-[#14144a] disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-label">Pay ₱{{ number_format($amount, 2) }}</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({ icon: 'success', title: 'Success', text: @json(session('success')), timer: 3000, showConfirmButton: false });
@endif
@if(session('error'))
    Swal.fire({ icon: 'error', title: 'Error', text: @json(session('error')), timer: 3000, showConfirmButton: false });
@endif

// ---------- Tabs ----------
function setActiveTab(tab) {
    const mobileTab = document.getElementById('tab-mobile');
    const cardTab = document.getElementById('tab-card');
    [mobileTab, cardTab].forEach(btn => {
        btn.classList.remove('bg-[#000053]', 'text-white');
        btn.classList.add('text-slate-500');
        btn.setAttribute('aria-selected', 'false');
    });
    const active = tab === 'mobile' ? mobileTab : cardTab;
    active.classList.add('bg-[#000053]', 'text-white');
    active.classList.remove('text-slate-500');
    active.setAttribute('aria-selected', 'true');
}

function switchTab(tab) {
    document.getElementById('section-mobile').classList.toggle('hidden', tab !== 'mobile');
    document.getElementById('section-card').classList.toggle('hidden', tab !== 'card');
    setActiveTab(tab);
}
setActiveTab('mobile');

// ---------- GCash selection ----------
function selectMobileMethod(method) {
    const img = document.getElementById(`img-${method}`);
    img.classList.add('border-[#000053]', 'bg-[#000053]/5');
    img.classList.remove('border-slate-200');

    const inputContainer = document.getElementById('mobile-fields');
    const input = document.getElementById('mobile-payment-input');
    const mobileMethodInput = document.getElementById('mobile_method');

    input.value = '';
    inputContainer.classList.remove('hidden');
    mobileMethodInput.value = method;
    input.focus();
}

// ---------- Mobile form submit ----------
const mobileForm = document.getElementById('mobile-payment-form');
mobileForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const method = document.getElementById('mobile_method').value;
    const input = document.getElementById('mobile-payment-input');
    const number = input.value.trim();

    if (!method) {
        Swal.fire({ icon: 'warning', title: 'Select a method', text: 'Please choose GCash to continue.', confirmButtonColor: '#000053' });
        return;
    }
    if (!/^09\d{9}$/.test(number)) {
        Swal.fire({ icon: 'warning', title: 'Check your number', text: 'Enter a valid 11-digit GCash number starting with 09.', confirmButtonColor: '#000053' });
        input.focus();
        return;
    }

    Swal.fire({
        title: 'Confirm payment',
        text: `Proceed to pay ₱{{ number_format($amount, 2) }} via GCash?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#000053',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed',
    }).then(result => {
        if (result.isConfirmed) {
            setButtonLoading('mobile-submit-btn', 'Redirecting…');
            mobileForm.submit();
        }
    });
});

function setButtonLoading(id, label) {
    const btn = document.getElementById(id);
    btn.disabled = true;
    btn.querySelector('.btn-label').textContent = label;
}

// ---------- Stripe ----------
const stripe = Stripe("{{ config('services.stripe.key') }}");
const elements = stripe.elements();
const card = elements.create('card', {
    style: {
        base: {
            fontSize: '16px',
            color: '#1e1e3f',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            '::placeholder': { color: '#94a3b8' },
        },
        invalid: { color: '#e53e3e', iconColor: '#e53e3e' }
    }
});
card.mount('#card-element');

const cardErrors = document.getElementById('card-errors');
card.on('change', (event) => {
    cardErrors.textContent = event.error ? event.error.message : '';
});

const cardForm = document.getElementById('payment-form');
cardForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    const confirm = await Swal.fire({
        title: 'Confirm payment',
        text: `Charge your card ₱{{ number_format($amount, 2) }}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#000053',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, pay now',
    });
    if (!confirm.isConfirmed) return;

    setButtonLoading('card-submit-btn', 'Processing…');

    const { error, paymentMethod } = await stripe.createPaymentMethod({
        type: 'card',
        card: card,
        billing_details: { name: cardForm.card_holder_name.value }
    });

    if (error) {
        cardErrors.textContent = error.message;
        resetCardButton();
        return;
    }

    const { paymentIntent, error: confirmError } = await stripe.confirmCardPayment("{{ $clientSecret }}", {
        payment_method: paymentMethod.id
    });

    if (confirmError) {
        Swal.fire({ icon: 'error', title: 'Payment failed', text: confirmError.message, confirmButtonColor: '#000053' });
        resetCardButton();
        return;
    }

    if (paymentIntent.status === 'succeeded') {
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_intent_id');
        hiddenInput.setAttribute('value', paymentIntent.id);
        cardForm.appendChild(hiddenInput);
        cardForm.submit();
    } else {
        resetCardButton();
    }
});

function resetCardButton() {
    const btn = document.getElementById('card-submit-btn');
    btn.disabled = false;
    btn.querySelector('.btn-label').textContent = 'Pay ₱{{ number_format($amount, 2) }}';
}
</script>
@endsection