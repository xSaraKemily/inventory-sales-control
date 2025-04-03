<?php

namespace App\Actions;

use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CreateOrUpdateInventoryAction
{
    public static function execute(Collection $data): void
    {
        Inventory::upsert(
            self::getFormattedDataToSave($data),
            ['product_id']
        );
    }

    private static function getFormattedDataToSave(Collection $data): array
    {
        $inventories = Inventory::whereIn('product_id', $data->pluck('product_id'))->get();
        $currentTimestamp = Carbon::now();

        $formatedData = $data->map(function ($product) use ($inventories, $currentTimestamp) {
            $productArr = $product->toArray();
            $inventory = $inventories->where('product_id', $product->product_id)->first();

            $lastUpdatedAt = $currentTimestamp;

            if ($inventory) {
                $productArr['quantity'] = $product->quantity + $inventory->quantity;
            } else {
                $lastUpdatedAt = null;
            }

            $productArr['last_updated'] = $lastUpdatedAt;

            return $productArr;
        });

        return $formatedData->toArray();
    }
}
