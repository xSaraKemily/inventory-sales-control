<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

abstract readonly class BaseDTO
{
    abstract public static function createFrom(array $data): self;

    public static function createFromMany(array $data): Collection
    {
        return Collection::make($data)->map(fn ($item) => static::createFrom($item));
    }
}
