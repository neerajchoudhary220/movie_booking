<?php

namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SeatBookedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $booking;
    public function __construct(Booking $booking)
    {
        $this->booking = $booking->load('user', 'show.movie', 'show.screen.theatre');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('show.' . $this->booking->show_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->booking->id,
            'seat' => $this->booking->seat_number,
            'user' => $this->booking->user->name,
            'theatre' => $this->booking->show->screen->theatre->name,
            'screen' => $this->booking->show->screen->name,
            'movie' => $this->booking->show->movie->title,
            'status' => $this->booking->status,
        ];
    }
}
