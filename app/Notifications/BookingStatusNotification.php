<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;
    public $status; // booked | confirmed | cancelled
    public $show;
    public $movie;
    public $screen;
    public $theatre;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking, string $status)
    {
        $this->booking = $booking;
        $this->status = $status;
        $this->show = $booking->show;
        $this->movie = $this->show->movie;
        $this->screen = $this->show->screen;
        $this->theatre = $this->screen->theatre;
        $this->user = $booking->user;
    }

    /**
     * Define channels
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build mail
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = match ($this->status) {
            'booked'    => '🎟 Seat Booking Confirmation',
            'confirmed' => '✅ Your Booking Has Been Confirmed',
            'cancelled' => '❌ Your Booking Has Been Cancelled',
            default     => '🎬 Booking Update',
        };

        return (new MailMessage)
            ->subject($title . ' - ' . $this->movie->title)
            ->view('emails.booking_status', [
                'booking' => $this->booking,
                'status' => $this->status,
                'movie' => $this->movie,
                'show' => $this->show,
                'screen' => $this->screen,
                'theatre' => $this->theatre,
                'user' => $this->user,
            ]);
    }

    /**
     * For database or broadcast (optional)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->status,
            'movie' => $this->movie->title,
            'theatre' => $this->theatre->name,
            'screen' => $this->screen->name,
        ];
    }
}
