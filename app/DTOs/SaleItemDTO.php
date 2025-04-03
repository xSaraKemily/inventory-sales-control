<?php

namespace App\DTOs;

readonly class SaleItemDTO extends BaseDTO
{
    public function __construct(
        public int $product_id,
        public int $quantity,
        public float $unit_price,
        public float $unit_cost,
    ) {}

    public static function createFrom(array $data): self
    {
        return new self(
            (int) $data['product_id'],
            (int) $data['quantity'],
            (float) $data['unit_price'],
            (float) $data['unit_cost']
        );
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'unit_cost' => $this->unit_cost,
        ];
    }
}
