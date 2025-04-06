<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceRequestDeclined extends Notification
{
    use Queueable;

    public $mechanicName;
    public $date;
    public $time;

    /**
     * Create a new notification instance.
     */
    public function __construct($mechanicName, $date, $time)
    {
        $this->mechanicName = $mechanicName;
        $this->date = $date;
        $this->time = $time; // Replace with actual mechanic name
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello! ' . $notifiable->name)
            ->line("Unfortunately, your service request scheduled on **$this->date at $this->time** was declined by $this->mechanicName.")
            ->line('Please try booking with another mechanic or choose a different time.')
            ->action('Book Again', url('/customer/service-requests/create'))
            ->line('Thank you for using our service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
