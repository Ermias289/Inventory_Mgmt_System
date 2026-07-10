<?php 

namespace App\Repositories;

use App\Models\Stock;
use App\Repositories\Contracts\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
    public function create(array $data): Stock
    {
        return Stock::create($data);
    }

    public function updateQuantity(int $quantity, Stock $stock): Stock
    {
        $stock->update([
            'quantity'=>$quantity
        ]);
    
        return $stock->fresh();    
    }
    
}