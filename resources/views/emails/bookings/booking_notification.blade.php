<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Notification</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: #f9fafb;
            color: #374151;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 640px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(90deg, #4f46e5, #6366f1);
            color: white;
            padding: 20px 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.3px;
        }

        .content {
            padding: 30px;
        }

        .content h2 {
            color: #111827;
            margin-bottom: 16px;
            font-size: 20px;
        }

        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        .info-box p {
            margin: 6px 0;
            line-height: 1.5;
            font-size: 14px;
        }

        .info-box strong {
            color: #111827;
        }

        .btn {
            display: inline-block;
            background-color: #4f46e5;
            color: white !important;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 22px;
            margin-top: 10px;
            transition: background 0.2s ease;
        }

        .btn:hover {
            background-color: #4338ca;
        }

        .footer {
            background: #f3f4f6;
            color: #6b7280;
            text-align: center;
            padding: 15px;
            font-size: 13px;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 24px 0;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <h1>🎬 New Booking Request</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Booking Details</h2>

            <div class="info-box">
                <p><strong>Movie:</strong> {{ $booking->show->movie->title }}</p>
                <p><strong>Theatre:</strong> {{ $booking->show->screen->theatre->name }}</p>
                <p><strong>Screen:</strong> {{ $booking->show->screen->name }}</p>
                <p><strong>Show Time:</strong> {{ \Carbon\Carbon::parse($booking->show->starts_at)->format('d M Y, h:i A') }}</p>
            </div>

            <h2>Customer Details</h2>
            <div class="info-box">
                <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                <p><strong>Email:</strong> {{ $booking->user->email }}</p>
            </div>

            <h2>Seats</h2>
            <div class="info-box">
                <p><strong>Seat Numbers:</strong> {{ $booking->items->pluck('seat.seat_number')->join(', ') }}</p>
                <p><strong>Total Seats:</strong> {{ $booking->items->count() }}</p>
                <p><strong>Total Amount:</strong> ₹{{ number_format($booking->total_amount, 2) }}</p>
            </div>

            <div class="divider"></div>

            <div style="text-align:center">
                <a href="#" class="btn">Manage Bookings</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>