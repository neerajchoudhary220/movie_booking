@php
use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Seat Booking Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 640px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            padding: 24px 32px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        .header h2 {
            color: #4f46e5;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .details-table th,
        .details-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .details-table th {
            color: #555;
            width: 35%;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .btn {
            display: inline-block;
            background: #4f46e5;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h2>🎟 New Seat Booking</h2>
            <p>A customer has booked seat(s) for your theatre show.</p>
        </div>

        <table class="details-table">
            <tr>
                <th>Customer Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Movie</th>
                <td>{{ $movie->title }}</td>
            </tr>
            <tr>
                <th>Theatre</th>
                <td>{{ $theatre->name }}</td>
            </tr>
            <tr>
                <th>Screen</th>
                <td>{{ $screen->name }}</td>
            </tr>
            <tr>
                <th>Showtime</th>
                <td>{{ Carbon::parse($show->starts_at)->format('d M Y, h:i A') }}</td>
            </tr>
            <tr>
                <th>Seats Booked</th>
                <td>
                    @foreach($booking->seats as $seat)
                    <span style="display:inline-block; background:#f3f4f6; border-radius:6px; padding:4px 8px; margin:2px;">
                        {{ $seat->seat_number }}
                    </span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Total Amount</th>
                <td>₹{{ number_format($booking->total_amount, 2) }}</td>
            </tr>
        </table>

        <div style="text-align:center">
            <a href="{{ $url }}" class="btn">View Booking</a>
        </div>

        <div class="footer">
            <p>Thank you for using <strong>{{ config('app.name') }}</strong>.</p>
            <p>This is an automated notification — please do not reply.</p>
        </div>
    </div>
</body>

</html>