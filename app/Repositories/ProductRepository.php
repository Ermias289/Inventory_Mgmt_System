<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(
    ?string $search = null,
    ?int $categoryId = null,
    int $perPage = 10
    ): LengthAwarePaginator
    {
        return Product::query()
            ->with([
                'category',
                'stock'
            ])

            ->when($search, function($query) use ($search){

                $query->where(function($q) use ($search){

                    $q->where('name','like',"%{$search}%")
                    ->orWhere('sku','like',"%{$search}%");

                });

            })

            ->when($categoryId, function($query) use ($categoryId){

                $query->where(
                    'category_id',
                    $categoryId
                );

            })

            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): ?Product
    {
        return Product::with('category', 'stock')->find($id);
    }

    public function findBySku(string $sku): ?Product
    {
        return Product::with('category', 'stock')->where('sku',$sku)->first();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh();
    }

    public function delete(Product $product): bool
    {
        return $product -> delete();
    }
}