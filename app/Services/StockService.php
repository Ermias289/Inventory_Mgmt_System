<?php
    
namespace App\Service;

use App\Repositories\StockRepositoryInterface;
use App\Models\Stock;

class StockService
{
    public function __construct(
        private readonly StockRepositoryInterface $stockRepository
    ){

    }
}