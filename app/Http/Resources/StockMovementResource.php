<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'type'=>$this->type,
            'quantity'=>$this->quantity,

            'reason'=>$this->reason,


            'product'=>[
                'id'=>$this->product->id,
                'name'=>$this->product->name
            ],


            'performed_by'=>[
                'id'=>$this->user?->id,
                'name'=>$this->user?->name
            ],

            'created_at'=>$this->created_at

        ];
    }
}
