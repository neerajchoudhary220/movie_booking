<?php

namespace App\Services;

use App\Models\Show;
use App\Models\ShowSeat;
use App\Models\Booking;
use App\Models\BookingSeat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingService
{
    /**
     * Reserve seats with transaction lock
     */
    public function reserveSeats(int $userId, int $showId, array $seatIds): Booking
    {
        return DB::transaction(function () use ($userId, $showId, $seatIds) {
            $show = Show::lockForUpdate()->findOrFail($showId);

            // Lock selected show_seats
            $rows = ShowSeat::where('show_id', $showId)
                ->whereIn('seat_id', $seatIds)
                ->lockForUpdate()
                ->get();

            if ($rows->count() !== count($seatIds)) {
                throw new \Exception('One or more seats not found.');
            }

            $now = Carbon::now();
            foreach ($rows as $row) {
                // release expired pending seats
                if ($row->status === ShowSeat::STATUS_PENDING && $row->locked_until && $row->locked_until->lt($now)) {
                    $row->status = ShowSeat::STATUS_AVAILABLE;
                    $row->locked_until = null;
                    $row->save();
                }

                if ($row->status !== ShowSeat::STATUS_AVAILABLE) {
                    throw new \Exception('Seat not available: ' . $row->seat_id);
                }
            }

            $priceMap = $show->price_map ?? [];
            $total = 0;

            // create booking
            $booking = Booking::create([
                'user_id' => $userId,
                'show_id' => $show->id,
                'status' => Booking::STATUS_PENDING,
                'total_amount' => 0,
                'expires_at' => Carbon::now()->addMinutes($show->lock_minutes),
            ]);

            foreach ($rows as $row) {
                $seatType = $row->seat->type ?? 'regular';
                $price = $row->price_override ?? ($priceMap[$seatType] ?? $show->base_price);

                $total += $price;

                $row->update([
                    'status' => ShowSeat::STATUS_PENDING,
                    'locked_until' => $booking->expires_at,
                ]);

                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'show_id' => $show->id,
                    'seat_id' => $row->seat_id,
                    'price' => $price,
                ]);
            }

            $booking->update(['total_amount' => $total]);

            return $booking;
        });
    }

    /**
     * Confirm booking
     */
    public function confirmBooking(int $bookingId, string $paymentRef = null)
    {
        DB::transaction(function () use ($bookingId, $paymentRef) {
            $booking = Booking::lockForUpdate()->findOrFail($bookingId);

            if ($booking->status !== Booking::STATUS_PENDING) {
                throw new \Exception('Booking not pending.');
            }

            if ($booking->expires_at && $booking->expires_at->isPast()) {
                throw new \Exception('Booking expired.');
            }

            $seatIds = $booking->items->pluck('seat_id')->all();

            $rows = ShowSeat::where('show_id', $booking->show_id)
                ->whereIn('seat_id', $seatIds)
                ->lockForUpdate()
                ->get();

            foreach ($rows as $row) {
                if ($row->status !== ShowSeat::STATUS_PENDING) {
                    throw new \Exception('Seat not pending anymore.');
                }

                $row->update([
                    'status' => ShowSeat::STATUS_BOOKED,
                    'locked_until' => null,
                ]);
            }

            $booking->update([
                'status' => Booking::STATUS_CONFIRMED,
                'payment_ref' => $paymentRef,
            ]);
        });
    }
}
