<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    public function __construct(public Product $product)
    {
        $this->product = $product;
    }

    public function via($notifiable): array
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
        )

        ->line('Minimum quantity:'
        .$this->product->stock->minimum_quantity);

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

    public function toDatabase($notifiable){
        return [
            'title' => 'Low Stock Alert',
            'product_id' =>$this->product->id,
            'product_name'=>$this->product->name, 
            'current_quantity'=>$this->product->stock->quantity,
            'minimum_quantity'=>$this->product->stock->minimum_quantity
        ];
    }
}
