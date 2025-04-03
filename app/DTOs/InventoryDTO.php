<?php

namespace App\DTOs;

readonly class InventoryDTO extends BaseDTO
{
    public function __construct(
        public int $product_id,
        public int $quantity
    ) {}

    public static function createFrom(array $data): self
    {
        return new self(
            (int) $data['product_id'],
            (int) $data['quantity']
        );
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ];
    }
}
