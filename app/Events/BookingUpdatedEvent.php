<?php

namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingUpdatedEvent implements ShouldBroadcastNow
{



    /**
     * Create a new event instance.
     */
    public $showId;
    public $seats;
    public $status;

    public function __construct(Booking $booking, $status)
    {
        $this->showId = $booking->show_id;
        $this->status = $status;
        $this->seats = $booking->items()->with('seat:id,status')->get();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('show.' . $this->showId),
        ];
    }

    public function broadcastAs()
    {
        return 'booking.updated';
    }
}
