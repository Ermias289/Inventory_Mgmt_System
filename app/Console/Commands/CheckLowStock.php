<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Product;
use App\Events\StockChanged;

// #[Signature('app:check-low-stock-command')]
// #[Description('Command description')]
class CheckLowStock extends Command
{
    protected $signature = 'inventory:check-low-stock';
    protected $description = 'Command description';
    
    public function handle()
    {
        Product::whereHas('stock', function($query){
            $query->whereColumn(
                'quantity',
                '<=',
                'minimum_quantity'
            );
        })
        ->each(function($product){
            event(
                new StockChanged($product)
            );
        });

        $this->info('Low Stock check completed');
    }
}
