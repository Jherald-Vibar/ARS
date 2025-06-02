<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function showForm($bookingId)
    {
        $booking = Booking::with(['passengers', 'flight'])->findOrFail($bookingId);
        $amount = $booking->calculateAmount($bookingId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'metadata' => [
                'booking_id' => $bookingId,
            ],
        ]);

        $clientSecret = $paymentIntent->client_secret;

        return view('payment.stripe', compact('booking', 'amount', 'clientSecret'));
    }

    public function processStripePayment(Request $request)
    {
        try {
            Payment::create([
                'booking_id' => $request->booking_id,
                'amount_paid' => $request->amount,
                'payment_method' => 'Stripe',
                'payment_date' => now(),
                'payment_status' => 'Paid',
            ]);

            $booking = Booking::where('id', $request->booking_id)->first();
            if ($booking) {
                $booking->update(['status' => "confirmed"]);
            }

            return redirect()->route('stripe-form', ['bid' => $request->booking_id])
                             ->with('success', 'Payment Successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment Failed: ' . $e->getMessage());
        }
    }
}
