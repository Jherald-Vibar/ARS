<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f8fa; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <div style="background-color: #004080; padding: 10px; text-align: center;">
            <img src="https://i.ibb.co/TqNsSz8t/494578167-989292679708197-8111641273777969453-n.png" alt="Voyair" style="height: 60px; margin-bottom: 10px;">
            <h2 style="color: white; margin: 0;">Booking Confirmed</h2>
        </div>
        <div style="padding: 20px;">
            <p style="font-size: 16px;">Dear <strong>{{ $passenger->full_name }}</strong>,</p>

            <p style="font-size: 15px;">
                We're happy to confirm your flight booking. Below are your flight details:
            </p>

            <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px;">
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Booking Number:</td>
                    <td style="padding: 8px;">{{ $booking->id }}</td>
                </tr>
                <tr style="background-color: #f1f1f1;">
                    <td style="padding: 8px; font-weight: bold;">Flight:</td>
                    <td style="padding: 8px;">{{ $booking->flight->flight_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">From:</td>
                    <td style="padding: 8px;">{{ $booking->flight->departureAirport->name }}</td>
                </tr>
                <tr style="background-color: #f1f1f1;">
                    <td style="padding: 8px; font-weight: bold;">To:</td>
                    <td style="padding: 8px;">{{ $booking->flight->arrivalAirport->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Departure:</td>
                    <td style="padding: 8px;">{{ $booking->flight->departure_date }} at {{ $booking->flight->departure_time }}</td>
                </tr>
                 <tr>
                    <td style="padding: 8px; font-weight: bold;">Seat No:</td>
                    <td style="padding: 8px;">{{ $passenger->seat_number }} </td>
                </tr>
            </table>

            <p style="margin-top: 20px; font-size: 15px;">
                Thank you for booking with us. We wish you a safe and pleasant journey!
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 13px; color: #666;">
            &copy; {{ date('Y') }} Voyair . All rights reserved.
        </div>
    </div>
</body>
</html>
