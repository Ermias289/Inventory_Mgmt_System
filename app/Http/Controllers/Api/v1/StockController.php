<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\StockService;
use App\Http\Requests\StockMovementRequest;


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
            $movement,
            'Stock increased successfully.'
        );

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
            $movement,
            'Stock decreased successfully.'
        );

    }


}