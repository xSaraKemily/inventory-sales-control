<?php

namespace App\Actions;

use App\DTOs\SaleItemDTO;
use App\Enums\SaleStatusEnum;
use App\Events\SaleCreated;
use App\Models\Sale;
use Illuminate\Support\Collection;

class CreateSaleAction
{
    public static function execute(Collection $itemDtos): Sale
    {
        $sale = Sale::create([
            ...self::calculateSaleTotals($itemDtos),
            'status' => SaleStatusEnum::COMPLETED
        ]);

        $sale->items()->createMany(
            self::formatDTOsToArray($itemDtos)
        );

        SaleCreated::broadcast($sale);

        return $sale;
    }

    private static function formatDTOsToArray(Collection $dtos): array
    {
        return $dtos->map(fn ($dto) => $dto->toArray())->toArray();
    }

    private static function calculateSaleTotals(Collection $itemDtos): array
    {
        $totalCost = 0;
        $totalAmount = 0;

        $itemDtos->each(function (SaleItemDTO $item) use (&$totalAmount, &$totalCost) {
            $totalAmount += $item->unit_price * $item->quantity;
            $totalCost += $item->unit_cost * $item->quantity;
        });

        $totalProfit = $totalAmount - $totalCost;

        return [
            'total_profit' => $totalProfit,
            'total_cost' => $totalCost,
            'total_amount' => $totalAmount,
        ];
    }
}
