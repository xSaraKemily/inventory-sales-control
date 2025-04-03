<?php

namespace App\Enums;

enum SaleStatusEnum: string
{
    case PENDING = 'PENDING';
    case COMPLETED = 'COMPLETED';

    public static function values(): array
    {
        return [
            self::PENDING->value,
            self::COMPLETED->value,
        ];
    }
}
