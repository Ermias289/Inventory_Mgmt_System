<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,

            'sku' => $this->sku,

            'description' => $this->description,

            'cost_price' => $this->cost_price,

            'selling_price' => $this->selling_price,

            'category' => [

                'id' => $this->category?->id,

                'name' => $this->category?->name,
            ],

            'stock' => [
                'quantity' => $this->stock?->quantity,
                'minimum_quantity' => $this->stock?->minimum_quantity,
            ],

            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
