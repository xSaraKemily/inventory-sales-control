<?php

namespace App\Actions;

use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class GetInventoryDetailsAction
{
    public static function execute(): JsonResponse
    {
        $inventory = Inventory::with('product')->get();

        $data = $inventory->map(function ($item) {
            return new InventoryResource($item);
        });

        return response()->json([
            'summary' => [
                'total_projected_profit' => self::getProjectedProfit($data),
            ],
            'inventory' => $data,
        ]);
    }

    private static function getProjectedProfit(Collection $inventories): float
    {
        return collect($inventories)->map(fn ($item) => $item->toArray(request()))->sum('projected_profit');
    }
}
