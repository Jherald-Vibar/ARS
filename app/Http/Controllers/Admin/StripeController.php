<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardingPass;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use App\Services\PayMongoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class StripeController extends Controller
{

    public function showForm($bookingId)
    {
        $booking = Booking::with(['passengers', 'flight'])->findOrFail($bookingId);
        $amount = $booking->calculateAmount($bookingId);
        $title = "Payment - Booking";

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'metadata' => [
                'booking_id' => $bookingId,
            ],
        ]);

        $clientSecret = $paymentIntent->client_secret;

        return view('payment.stripe', compact('booking', 'amount', 'clientSecret', 'title'));
    }

    public function processStripePayment(Request $request)
    {
        try {
            $payment = Payment::create([
                'booking_id' => $request->booking_id,
                'amount_paid' => $request->amount,
                'payment_method' => 'Stripe',
                'payment_date' => now(),
                'payment_status' => 'Paid',
            ]);

            $booking = Booking::with(['passengers', 'flight'])->where('id', $request->booking_id)->first();
            if ($booking) {
                $booking->update(['status' => "confirmed"]);
            }

            foreach ($booking->passengers as $passenger) {
                BoardingPass::create([
                    'passenger_id' => $passenger->id,
                    'flight_id' => $booking->flight->id,
                    'seat_number' => $passenger->seat_number,
                    'boarding_time' => $booking->flight->departure_time,
                ]);
            }


            $latestReceipt = Receipt::latest('id')->first();
            $rNumber = $latestReceipt ? $latestReceipt->id + 1001 : 1001;

            Receipt::create([
                'payment_id' => $payment->payment_id,
                'receipt_number' => 'R-' . $rNumber,
                'date_issued' => today(),
            ]);

           foreach ($booking->passengers as $passenger) {
            Mail::send('email.confirm_booking_mail', [
                'booking' => $booking,
                'passenger' => $passenger,
            ], function ($message) use ($passenger) {
                $message->to($passenger->email)->subject('Your Booking Confirmation');
            });
        }




            return redirect()->route('passenger-boarding-pass', ['bid' => $request->booking_id])
                             ->with('success', 'Payment Successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment Failed: ' . $e->getMessage());
        }
    }

    protected $paymongo;
    public function __construct(PayMongoService $paymongo)
    {
        $this->paymongo = $paymongo;
    }

    public function start(Request $request)
{
    $request->validate([
        'booking_id' => 'required|exists:bookings,id',
        'amount' => 'required|numeric|min:1',
        'gcash_number' => 'required|string',
    ]);

    $booking = Booking::findOrFail($request->booking_id);
    $amountInCentavos = intval($request->amount * 100);
    $source = $this->paymongo->createGCashSource($amountInCentavos);
    if (!$source || !isset($source['data']['attributes']['redirect']['checkout_url'])) {
        return redirect()->back()->with('error', 'Payment initiation failed. Please try again.');
    }

    $redirectUrl = $source['data']['attributes']['redirect']['checkout_url'];

    $payment = Payment::create([
        'booking_id' => $request->booking_id,
        'amount_paid' => $request->amount,
        'payment_method' => 'Gcash',
        'payment_date' => now(),
        'payment_status' => 'Paid',
    ]);

    $booking = Booking::where('id', $request->booking_id)->first();
    if ($booking) {
        $booking->update(['status' => "confirmed"]);
    }

    foreach ($booking->passengers as $passenger) {
        BoardingPass::create([
            'passenger_id' => $passenger->id,
            'flight_id' => $booking->flight->id,
            'seat_number' => $passenger->seat_number,
            'boarding_time' => $booking->flight->departure_time,
        ]);
    }


    $latestReceipt = Receipt::latest('id')->first();
    $rNumber = $latestReceipt ? $latestReceipt->id + 1001 : 1001;

    Receipt::create([
        'payment_id' => $payment->payment_id,
        'receipt_number' => 'R-' . $rNumber,
        'date_issued' => today(),
    ]);


     foreach ($booking->passengers as $passenger) {
            Mail::send('email.confirm_booking_mail', [
                'booking' => $booking,
                'passenger' => $passenger,
            ], function ($message) use ($passenger) {
                $message->to($passenger->email)->subject('Your Booking Confirmation');
            });
        }





    return redirect()->route('passenger-boarding-pass', ['bid' => $request->booking_id])
                             ->with('success', 'Payment Successful!');
    }

    public function success()
    {
        $title = "Payment Success";
        return view('payment.success', compact('title'));
    }

    public function failed(){
        return view('payment.failed');
    }


    public function boardingPage($bid) {
        $booking = Booking::with('passengers')->find($bid);

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }
        $title = "Payment Booking";
        $passengerIds = $booking->passengers->pluck('id');
        $boardingPasses = BoardingPass::whereIn('passenger_id', $passengerIds)->get();
        return view('payment.boarding_pass', compact('title', 'booking', 'boardingPasses'));
    }



    public function receiptPdf($bid)
    {
        $booking = Booking::with(['passengers', 'payment.receipt'])->find($bid);


        $receipt = $booking->payment->receipt;

        $passengerIds = $booking->passengers->pluck('id');
        $boardingPasses = BoardingPass::whereIn('passenger_id', $passengerIds)->get();

        $pdf = Pdf::loadView('payment.pdf', compact('booking', 'receipt', 'boardingPasses'));

        return $pdf->download('receipt_ticket.pdf');
    }
}
