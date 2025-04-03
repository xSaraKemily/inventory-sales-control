<?php

namespace App\Http\Resources;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Collection;

class CreateSaleAction
{
    public static function execute(Collection $dtos): Sale
    {
        $sale = Sale::create();

        $sale->items()->createMany(
            self::formatDTOsToArray($dtos)
        );

        self::updateSaleStatistics($sale);

        return $sale;
    }

    private static function formatDTOsToArray(Collection $dtos): array
    {
        return $dtos->map(fn ($dto) => $dto->toArray())->toArray();
    }

    private static function updateSaleStatistics(Sale $sale): void //TODO: mudar caso seja pra ficar assim, pra fazer o calculo antes de adc os itens
    {
        $totalCost = 0;
        $totalAmount = 0;

        $sale->items->each(function (SaleItem $item) use (&$totalAmount, &$totalCost) {
            $totalAmount += $item->unit_price * $item->quantidade;
            $totalCost += $item->unit_cost * $item->quantidade;
        });

        $totalProfit = $totalAmount - $totalCost;

        $sale->update([
            'total_profit' => $totalProfit,
            'total_cost' => $totalCost,
            'total_amount' => $totalAmount,
            'status' => 'COMPLETED'
        ]);
    }
}
