<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Product;
use App\Repositories\Contracts\StockRepositoryInterface;


class ProductService{

    public function __construct(
        private readonly ProductRepositoryInterface $productRepository, 
        private readonly StockRepositoryInterface $stockRepository
        ){

    }

    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data)
        {
            $product = $this->productRepository->create($data);

            $this->$stockRepository->create([
                'product_id' => $product->id,
                'quantity' => 0,
                'minimum_quantity' => 5
            ]);

            return $product->load([
                'category',
                'stock'
            ]);
        });
    }

    public function paginate(
        ?string $search = null,
        ?int $categoryId = null,
        int $perPage = 10
    )
    {
        return $this->productRepository->paginate(
            $search, 
            $categoryId,
            $perPage
        );
    }
}