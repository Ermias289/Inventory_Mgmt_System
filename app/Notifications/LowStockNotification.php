<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class LowStockNotification extends Notification
{
    use Queueable;

    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via(object $notifiable): array
    {
        return [
            'database',
            'mail'
        ];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
               ->subject('Low Stock Alert')

        ->line(
            "{$this->product->name} is running low."
        )

        ->line(
            "Remaining: {$this->product->stock->quantity}"
        );
    }

    public function toArray(object $notifiable): array
    {
         return [
            'product_id'=>$this->product->id,
            'product'=>$this->product->name,
            'quantity'=>$this->product->stock?->quantity,
            'minimum'=>$this->product->stock->minimum_quantity
        ];
    }
}
