<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Repositories\Contracts\StockRepositoryInterface;
use App\Services\SkuService;

class ProductService{

    public function __construct(
        private readonly ProductRepositoryInterface $productRepository, 
        private readonly StockRepositoryInterface $stockRepository,
        private readonly SkuService $skuService
        ){

    }

    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data)
        {
            if(empty($data['sku'])){
                $data['sku'] = $this-> skuService->generate($data['name']);
            }

            $product = $this->productRepository->create($data);


            $this->stockRepository->create([
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

    public function update(
        Product $product, 
        array $data    
    ):Product
    {
        return DB::transaction (function() use($product, $data){
            $product = $this->productRepository
                ->update($product, $data);

            return $product->load([
                'category',
                'stock'
            ]);
        });
    }

    public function delete(Product $product): void
    {

        DB::transaction(function() use($product){

            $this->productRepository
                ->delete($product);

        });

    }
}