<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>  $this->id,
            'quantity' => $this->quantity,
            'total_cost_price' => $this->quantity * $this->product->cost_price,
            'total_sale_price' => $this->quantity * $this->product->sale_price,
            'projected_profit' => ($this->product->sale_price - $this->product->cost_price) * $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product' => new ProductResource($this->product)
        ];
    }
}
