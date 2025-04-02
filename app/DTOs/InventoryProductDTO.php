<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

readonly class InventoryProductDTO
{
    public function __construct(
        public int $product_id,
        public int $quantity
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['product_id'],
            $data['quantity']
        );
    }

    public static function fromMany(array $data): Collection
    {
        return Collection::make($data)->map(fn ($item) => self::fromRequest($item));
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ];
    }
}
