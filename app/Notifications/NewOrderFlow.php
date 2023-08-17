<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\OrderFlow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderFlow extends Notification
{
    use Queueable;

    public function __construct(private readonly OrderFlow $orderFlow)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Aprova Legal - OS: Novo acompanhamento')
            ->markdown('mail.new-order-flow', [
                'user'      => $notifiable,
                'orderFlow' => $this->orderFlow,
                'orderLink' => route('filament.resources.orders.edit', $this->orderFlow->order),
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
