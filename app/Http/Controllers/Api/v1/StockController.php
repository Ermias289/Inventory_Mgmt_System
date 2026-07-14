<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\StockService;
use App\Http\Requests\StockMovementRequest;
use App\Models\StockMovement;
use App\Http\Resources\StockMovementResource;

class StockController extends Controller
{


    public function __construct(
        private readonly StockService $stockService
    )
    {

    }


    public function increase(
        StockMovementRequest $request,
        Product $product
    )
    {

        $movement =
            $this->stockService->increase(
                $product,
                $request->quantity,
                $request->reason
            );


        return $this->successResponse(
            new StockMovementResource($movement),
            'Stock increased successfully.'
        );

        event(new StockChanged($product->fresh()));

    }



    public function decrease(
        StockMovementRequest $request,
        Product $product
    )
    {

        $movement =
            $this->stockService->decrease(
                $product,
                $request->quantity,
                $request->reason
            );


        return $this->successResponse(
            new StockMovementResource($movement),
            'Stock decreased successfully.'
        );

    }

    public function history(Product $product)
    {
        $movements = StockMovement::query()
            ->where(    
                'product_id',
                $product->id
            )
            ->with([
                'user'
            ])
            ->latest()
            ->paginate(10);


        return $this->successResponse(
           StockMovementResource::collection($movements),
            'Stock history retrieved successfully.'
        );
    }

}