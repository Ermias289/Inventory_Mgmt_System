<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\StockChanged;
use Illuminate\Support\Facades\log;

class StockService
{
    public function increase(
        Product $product,
        int $quantity,
        string $reason
    )
    {

        return DB::transaction(function() use(
            $product,
            $quantity,
            $reason
        ){

            $product->stock()
                ->increment(
                    'quantity',
                    $quantity
                );

            $movement = StockMovement::create([

                'product_id'=>$product->id,

                'user_id'=>request()->user()->id,

                'type'=>'IN',

                'quantity'=>$quantity,

                'reason'=>$reason


            ]);
            
            activity()
                ->performedOn($product)
                ->causedBy(auth()->user->id)
                ->withProperties([
                    'type'=>'IN',
                    'quantity'=>$quantity,
                    'reason'=>$reason
                ])
                ->log('Stock increased');

            event(new StockChanged($product->fresh()));

            return $movement;

        });
    }       

    public function decrease(
        Product $product,
        int $quantity,
        string $reason
    )
    {

        return DB::transaction(function() use(
            $product,
            $quantity,
            $reason
        ){

            if($product->stock->quantity < $quantity)
            {
                throw new \Exception(
                    'Insufficient stock quantity.'
                );
            }


            $product->stock()
                ->decrement(
                    'quantity',
                    $quantity
                );


            $movement = StockMovement::create([

                'product_id'=>$product->id,

                'user_id'=>request()->user()->id,

                'type'=>'OUT',

                'quantity'=>$quantity,

                'reason'=>$reason

            ]);

            activity()
                ->performedOn($product)
                ->causedBy(auth()->user->id)
                ->withProperties([
                    'type'=>'OUT',
                    'quantity'=>$quantity,
                    'reason'=>$reason
                ])
                ->log('Stock decreased');
                
            event(new StockChanged($product->fresh()));
            return $movement;
        });

    }

    public function adjust(
        Product $product,
        int $quantity,
        string $reason
    )
    {

        return DB::transaction(function() use(
            $product,
            $quantity,
            $reason
        ){

            $product->stock()
                ->update([
                    'quantity'=>$quantity
                ]);


            $movement = StockMovement::create([

                'product_id'=>$product->id,

                'user_id'=>request()->user()->id,

                'type'=>'ADJUSTMENT',

                'quantity'=>$quantity,

                'reason'=>$reason

            ]);
            event(new StockChanged($product->fresh()));
            return $movement;
        });

    }
}