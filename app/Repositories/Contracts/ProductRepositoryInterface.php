<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface ProductRepositoryInterface
{
    public function paginate(
        ?string $search = null,
        ?int $categoryId = null,
        int $perPage = 10
    ): LengthAwarePaginator;

    public function findById(int $id): ?Product;
    
    public function findBySku(string $sku): ?Product;
    
    public function create(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function delete(Product $product): bool;
}


