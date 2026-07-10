<?php

namespace App\Repositories\Contracts;

use App\Models\Stock;

interface StockRepositoryInterface
{
    public function create(array $data): Stock;

    public function updateQuantity(int $quantity, Stock $stock): Stock;

    // public function findByProduct(Product $product): Stock
}