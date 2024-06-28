<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderClosed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $order;
    public function __construct($order)
    {
        $this->order = $order;
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
        $url = url('/orders/' . $this->order->id);
        $path = storage_path('app/pdf_receipts/' .
            $this->order->receipt_url);
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('One of your orders has been paid!')
            ->line('It is available online')
            ->action('View Order', $url)
            ->line('The file is also available as an ' .
                'attachment in this email')
            ->line('Thank you for using our application!')
            ->attach($path);
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
