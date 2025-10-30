@php
use Carbon\Carbon;
$statusColor = [
'booked' => '#4f46e5',
'confirmed' => '#16a34a',
'cancelled' => '#dc2626',
][$status] ?? '#374151';
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Booking Update</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 640px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 24px 32px;
        }

        h2 {
            color: {
                    {
                    $statusColor
                }
            }

            ;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .info-table th,
        .info-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .info-table th {
            width: 35%;
            color: #666;
        }

        .status-label {
            display: inline-block;

            background: {
                    {
                    $statusColor
                }
            }

            ;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>
            @if($status === 'booked') 🎟 Seat Booking Received
            @elseif($status === 'confirmed') ✅ Booking Confirmed
            @elseif($status === 'cancelled') ❌ Booking Cancelled
            @else 🎬 Booking Update
            @endif
        </h2>

        <p>
            Hello {{ $user->name }},<br>
            Your booking for <strong>{{ $movie->title }}</strong> has been
            <span class="status-label">{{ ucfirst($status) }}</span>.
        </p>

        <table class="info-table">
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
                <th>Show Time</th>
                <td>{{ Carbon::parse($show->starts_at)->format('d M Y, h:i A') }}</td>
            </tr>
            <tr>
                <th>Seats</th>
                <td>
                    @foreach($booking->seats as $seat)
                    <span style="background:#f3f4f6;border-radius:5px;padding:4px 8px;margin:2px;display:inline-block;">
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

        <p style="margin-top:20px;color:#555;">
            Thank you for booking with <strong>{{ config('app.name') }}</strong>.<br>
            We hope you enjoy your show! 🎬
        </p>
    </div>
</body>

</html>