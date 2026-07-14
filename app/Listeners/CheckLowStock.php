<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckLowStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $product = $event->product;

        if($product->stock->quantity<=$product->stock->minimum_quantity){
            
        }
    }
}
