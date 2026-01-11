<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Receipt & Ticket</title>
<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 14px;
        color: #333;
        margin: 0;
        padding: 20px;
        background: #f4f6f8;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .section {
        margin-bottom: 30px;
    }
    .title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #222;
        border-left: 6px solid #4f46e5;
        padding-left: 12px;
        letter-spacing: 0.5px;
    }
    p {
        margin: 6px 0;
        line-height: 1.4;
    }
    .receipt-info p {
        font-size: 15px;
    }

    /* Ticket Styles */
    .ticket {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .ticket-content {
        position: relative;
        background: #5b5a66;
        color: white;
        padding: 25px 30px;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
        overflow: hidden;
    }

    /* Circular ticket edges */
    .ticket-content::before,
    .ticket-content::after {
        content: "";
        position: absolute;
        top: 50%;
        width: 40px;
        height: 40px;
        background: #f4f6f8;
        border-radius: 50%;
        transform: translateY(-50%);
        z-index: 1;
    }
    .ticket-content::before {
        left: -20px;
    }
    .ticket-content::after {
        right: -20px;
    }

    .ticket-header {
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        letter-spacing: 3px;
        margin-bottom: 20px;
        text-transform: uppercase;
        user-select: none;
    }

    .ticket-info {
        display: flex;
        justify-content: space-between;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 20px;
        user-select: none;
    }
    .ticket-info div {
        width: 48%;
    }

    .ticket-info p strong {
        display: inline-block;
        width: 110px;
    }

    .passengers {
        font-size: 16px;
        border-top: 1px dashed rgba(255,255,255,0.5);
        padding-top: 15px;
        user-select: none;
    }
    .passengers strong {
        display: block;
        margin-bottom: 8px;
        font-weight: 700;
    }
    .passengers p {
        margin: 4px 0;
        font-weight: 500;
    }

    /* Optional: small barcode style box */
    .barcode {
        position: absolute;
        bottom: 20px;
        right: 30px;
        width: 120px;
        height: 30px;
        background: linear-gradient(90deg, black 10%, white 10%, white 20%, black 20%, black 30%, white 30%, white 40%, black 40%, black 50%, white 50%, white 60%, black 60%, black 70%, white 70%, white 80%, black 80%, black 90%, white 90%);
        filter: drop-shadow(0 0 1px rgba(0,0,0,0.5));
        user-select: none;
    }
</style>
</head>
<body>
<div class="container">
    <div class="section">
        <div class="title">Receipt</div>
        <p>Receipt No: {{ $receipt->id }}</p>
        <p>Amount Paid: {{ number_format($receipt->payment->amount_paid, 2) }}</p>
        <p>Payment Date: {{ \Carbon\Carbon::parse($receipt->payment->created_at)->format('M d, Y h:i A') }}</p>
    </div>

    <div class="section ticket">
        @foreach ($boardingPasses as $pass)
            <div class="ticket-content">
                <div class="ticket-header">E-Ticket Itinerary</div>
                <div class="ticket-info">
                    <div>
                        <p><strong>Flight Number:</strong> {{ $booking->flight->flight_number }}</p>
                        <p><strong>Departure:</strong> {{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('M d, Y h:i A') }}</p>
                        <p><strong>From:</strong> {{ $booking->flight->departureAirport->city }}, {{ $booking->flight->departureAirport->country }}</p>
                    </div>
                    <div>
                        <p><strong>Arrival:</strong> {{ \Carbon\Carbon::parse($booking->flight->arrival_time)->format('M d, Y h:i A') }}</p>
                        <p><strong>To:</strong> {{ $booking->flight->arrivalAirport->city }}, {{ $booking->flight->arrivalAirport->country }}</p>
                    </div>
                </div>

                <div class="passengers">
                    <strong>Passenger:</strong>
                    <p>- {{ $pass->passenger->full_name ?? 'Name not found' }}</p>
                </div>

                <div class="barcode"></div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
