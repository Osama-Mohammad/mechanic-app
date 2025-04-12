<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessful extends Notification  implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $mechanicName;
    public $amount;
    public $serviceName;
    public $transactionId;

    public function __construct($mechanicName, $amount, $serviceName, $transactionId)
    {
        $this->mechanicName = $mechanicName;
        $this->amount = $amount;
        $this->serviceName = $serviceName;
        $this->transactionId = $transactionId;
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
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line("Your payment of **\${$this->amount}** for **{$this->serviceName}** with **{$this->mechanicName}** was successful.")
            ->line("Transaction ID: `{$this->transactionId}`")
            ->line("Thank you for trusting us with your service request!")
            ->action('View Your Requests', url('/customer/service-requests'))
            ->line('We appreciate your business!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'mechanic_name' => $this->mechanicName,
            'amount' => $this->amount,
            'service_name' => $this->serviceName,
            'transaction_id' => $this->transactionId,
        ];
    }
}
