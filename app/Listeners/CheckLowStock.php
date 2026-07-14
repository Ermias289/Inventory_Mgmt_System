<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\StockChanged;
use App\Notifications\LowStockNotification;
use App\Models\User;
use Illuminate\Support\Facades\log;

class CheckLowStock
{
    
    public function __construct()
    {
    
    }

   
    public function handle(StockChanged $event): void
    {
        $product = $event->product;

        logger("Stock Changed for ".$product->name);

        if($product->stock->quantity<=$product->stock->minimum_quantity){
            logger(
                "Low Stock: ".$product->name
            );

            $users = User::permission('inventory.stock.alerts')->get();


            if($users->isEmpty())
            {
                Log::warning(
                    'No users have stock.manage permission'
                );

                return;
            }


            $users->each(function($user) use($product){

                $user->notify(
                    new LowStockNotification($product)
                );

            });
        }
    }
}
